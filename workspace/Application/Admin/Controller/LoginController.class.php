<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends CommonController {
	
	/**
	* 后台首页
	* @author niushiyao
	* @date   2016-09-12
	* @return
	*/
    public function index()
    {
        $this->assign('title','网站管理后台');
    	$this->display();
    }
	
	/**
	* 登录验证方法
	* @author niushiyao
	* @date 2016-09-11
	*/
	public function check()
	{
		$username = I('post.username','','trim');
		$password = I('post.password','','trim');
		if(!$username)
		{
			show(false,'用户名不能为空');
		}
		if(!$password)
		{
			show(false,'密码不能为空');
		}
		
		$res = D('Admin')->get_rows(array('username' => $username));
		if(!$res)
		{
			show(false,'用户名错误');
		}
		if($res['password'] != getMd5Pwd($password))
		{
			show(false,'密码不正确');
		}
		session('adminUser', $res);
		session(array('name' => 'adminUser','expire' => 3600));
		show(true,'登录成功');
	}
	
	/**
	* 退出方法
	* @author niushiyao
	* @date   2016-09-12
	*/
	public function loginout()
	{
		session("adminUser",null);
		redirect("/admin.php?c=login");
	}
}