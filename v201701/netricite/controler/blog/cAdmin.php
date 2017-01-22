<?php
namespace  Netricite\Controler\Blog;

use Netricite\Framework as fw;
use Netricite\Model\Blog as blog;

/**
 * administration controler
 *
 */
class cAdmin extends fw\fwControlerFilter
{
    private $comment;
    /**
     * Constructor 
     */
    public function __construct(){
		trace(debug_backtrace()); 								
				
        $this->model = new blog\mBlog();
        $this->comment = new blog\mComment();
    }
    
    /**
     * Get application data
     * {@inheritDoc}
     * @see \Netricite\Framework\fwControler::getAppData()
     * @return array of application data
     */
    public function getAppData() {
        $appdata=array(array('posts' => $posts, 
            'comments' => $comments));
        return $appdata;
    }
}