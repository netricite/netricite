<?php
namespace  Netricite\Model\Blog;

use Netricite\Framework as fw;


/**
 * DAL: management of the BLOG object
 *
 * @author jp
 * @version 2016-14
 *
 */
class mBlog extends fw\fwDao {

    /**
     * constructor
     */
    public function __construct()
    {
        appTrace(debug_backtrace());
        $this->table = "blog";
    }
}