<?php
namespace  Netricite\Controler\Blog;

use Netricite\Framework as fw;
use Netricite\Model\Blog as blog;

const APPLICATION = "blog";

//represente one post of the blog
/**
 * @author jp
 * @version 2016-13
 * 
 * Manage one post of the blog with associated comments
 * user must be login
 */
class cComment extends fw\fwControlerSession {

  private $blog;
  private $post;

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace());
	
    $this->blog = new blog\mBlog();
    $this->post = new blog\mPost();
    $this->model = new blog\mComment();
  }

  /**
   * **** actions
   * post and comments
   * 
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::index()
   */
  public function index() {
  	appTrace(debug_backtrace());
  	if (!empty($this->request->getParameter("postid"))) {
  	    $this->generateView(getAppData());
  	} else {
  	    $this->redirect("blog","blog");
  	}
  }
  
  /**
   * Get application data
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::getAppData()
   * @return array of application data
   */
  public function getAppData() {
      $id = $this->request->getParameter("postid");
      $posts = $this->post->getRecord($id);
      //var_dump($posts);
      $comments = $this->model->getRecords($id);
      //var_dump($comments);
      $blogId = $posts['blogid'];
      $blogs = $this->blog->getRecord($blogId);
      $appdata=array('blog' => $blogs, 'post' => $posts, 'comments' => $comments  );
      return $appdata;
  }
  /**
   * 
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::save()
   */
  public function save() {
      appTrace(debug_backtrace(), $this->request->parameters);
      $rc = parent::saveData($_POST['data']);
      $this->redirect("blog","comment", "postid=" . $_POST['data']['postid']  );                                          //refresh page
     
  }
}