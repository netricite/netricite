<?php
namespace Netricite\Framework;

use Netricite\Framework as fw;

/**
 *
 * @author jp
 * @version 2016-14
 *         
 *          application cache management (based on https://www.grafikart.fr/tutoriels/php/class-cache-340)
 */
class fwCache extends fw\fwObject
{

    private $dirname;
    // cache directory
    private $duration;
    // cache duration (minutes)
    private $buffer;
    // data cache
    CONST EXTENSION = '.html';
    // for cache manual display
    /**
     * new fwCache
     *
     * @param string $dirname            
     * @param number $duration            
     */
    public function __construct($dirname = "", $duration = 60)
    {
        parent::__construct();
        // fwTrace(debug_backtrace());
        
        // $this->dirname = (empty($dirname)) ? $GLOBALS['application.path'] . "public/cache/" : $dirname;
        $this->dirname = (empty($dirname)) ? $GLOBALS['application.path'] . fw\fwConfiguration::get("site.cache.path") : $dirname;
        $this->duration = $duration;
        $this->logger->addDebug($this->dirname, debug_backtrace());
    }

    /**
     * write in the cache
     *
     * @param unknown $filename            
     * @param unknown $content            
     */
    public function write($filename, $content)
    {
        $this->logger->addInfo("write: " . $this->dirname . $filename . $this::EXTENSION);
        return file_put_contents($this->dirname . $filename . $this::EXTENSION, $content);
    }

    /**
     * read the cache
     *
     * @param unknown $filename            
     * @return boolean|string
     */
    public function read($filename)
    {
        $file = $this->dirname . $filename . $this::EXTENSION;
        if (! file_exists($file))
            return false;
        $lifetime = (time() - filemtime($file)) / 60;
        if ($lifetime > $this->duration)
            return false;
        return file_get_contents($file);
    }

    /**
     * clear one file ine the cache
     *
     * @param unknown $filename            
     */
    public function delete($filename)
    {
        $file = $this->dirname . $filename . $this::EXTENSION;
        $this->logger->addDebug("delete." . $file, debug_backtrace());
        
        if (file_exists($file))
            unlink($file);
        else
            $this->logger->addError("Delete cache file not found." . $file);
        // fwWatch(array("I-Delete cache file not found"=> $file ), "", get_class($this));
    }

    /**
     * clear the cache
     */
    public function clear()
    {
        $files = glob($this->dirname . "*");
        // fwTrace(debug_backtrace(), $files);
        $this->logger->addInfo("clear", $files);
        foreach ($files as $file) {
            // fwWatch(array("I-Delete cache file"=> $file ), "", get_class($this));
            $this->logger->addInfo("Delete cache file." . $file);
            unlink($file);
        }
    }

    /**
     * require file
     *
     * @param unknown $filename            
     * @param unknown $cachename
     *            (buffer created by start)
     */
    public function requireFile($filename, $cachename = null)
    {
        $chunks = explode('/', $filename);
        $form = $chunks[count($chunks) - 1];
        $cachename = empty($cachename) ? $_SESSION['lang'] . "_" . $form : $cachename;
        if ($content = $this->read($cachename)) {
            // fwTrace(debug_backtrace(), "", "display cache." . $cachename);
            $this->logger->addInfo("echo cache." . $cachename);
            echo $content; // display cache
            return TRUE;
        }
        // record cache
        if (! file_exists($filename))
            throw new \exception("requirefile file not found(" . $filename . ")");
        ob_start();
        require $filename;
        $content = ob_get_clean();
        $this->write($cachename, $content); // write cache
        echo $content;
        return TRUE;
    }

    /**
     * require file
     *
     * @param unknown $filename            
     * @param unknown $cachename
     *            (buffer created by start)
     */
    public function requireFile2($path, $filename, $cachename = null)
    {
        if (! $cachename)
            $cachename = $_SESSION['lang'] . "_" . $filename;
        if ($content = $this->read($cachename)) {
            fwTrace(debug_backtrace(), "", "display cache " . $cachename);
            $this->logger->addInfo("echo cache." . $cachename);
            echo $content; // display cache
            return TRUE;
        }
        
        $file = $path . $_SESSION['lang'] . "_" . $filename;
        // record cache
        if (! file_exists($file))
            throw new \exception("requirefile file not found(" . $filename . ")");
        fwTrace(debug_backtrace(), "", "write cache " . $cachename);
        ob_start();
        require $file;
        $content = ob_get_clean();
        $this->write($cachename, $content); // write cache
        echo $content;
        return TRUE;
    }

    /**
     * start recording html in a buffer
     *
     * @param unknown $cachename            
     * @return boolean
     */
    public function start($cachename)
    {
        if ($content = $this->read($cachename)) {
            echo $content; // display cache
            $this->buffer = false; // not to display in 'end' function
            return TRUE;
        }
        // record cache
        ob_start();
        $this->buffer = $cachename;
    }

    /**
     * end recording html and buffer display
     *
     * @return boolean
     */
    public function end()
    {
        if (! $this->buffer)
            return false; // cache displayed during 'start' function
        $content = ob_get_clean();
        $this->write($this->buffer, $content); // write cache
        echo $content; // display cache
    }
}