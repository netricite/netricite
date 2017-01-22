<?php
namespace  Netricite\Controler\Blog;

use Netricite\Framework as fw;
use Netricite\Model\Blog as blog;

//represente one post of the blog
/**
 * @author jp
 * @version 2016-13
 * 
 * Manage one post of the blog with associated comments
 * user must be login
 */
class cPost extends fw\fwControlerSession {

  private $blog;

  /**
   * constructor
   */
  public function __construct() {
  	appTrace(debug_backtrace());  
  	$this->model = new blog\mPost();
    $this->blog = new blog\mBlog();
  }
  
  // **** actions
  // post and comments
  /**
   * **** actions
   * post and comments
   * 
   * {@inheritDoc}
   * @see \Netricite\Framework\fwControler::index()
   */
  public function index() {
  	appTrace(debug_backtrace());
  	if (!empty($this->request->getParameter("blogid"))) {
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
      $blogId = $this->request->getParameter("blogid");
	  $blogs = $this->blog->getRecord($blogId);
	  $posts = $this->model->getRecords($blogId);
      $appdata=array('blog' => $blogs, 'posts' => $posts );
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
      $this->redirect("blog","post", "blogid=" . $_POST['data']['blogid']  );                                          //refresh page
     
  }

}