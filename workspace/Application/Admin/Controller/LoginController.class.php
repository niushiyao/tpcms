<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){

    	return $this->display();
    }
	
	/**
	* 登录验证方法
	* @author niushiyao
	* @date 2016-09-11
	*/
	public function check()
	{
		print_r($_POST);
	}
}