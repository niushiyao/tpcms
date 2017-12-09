<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    
    public function __construct(){
		parent::__construct();
		//网站配置信息
		$this->get_basic_info();
		//网站栏目
		$this->get_menus();
	}
	
	/**
	* 头部公共部分配置信息，栏目
	* @author niushiyao
	* @date   2016-10-15
	*/
	public function get_basic_info()
	{
		$basic_info = D("Basic")->get_basic_info();
    	$this->assign('basic_info',$basic_info);
	}
	
	/**
	* 获得网站栏目
	* @author niushiyao
	* @date   2016-10-15
	*/
	public function get_menus()
	{
		$menus = D("Menu")->getFrontMenus();
		$this->assign("menus",$menus);
	}

	/**
	 * 错误的提示页面error
	 * @author niushiyao
	 * @date   2016-10-15
	 */
	public function show_error($message = "出错喽。。。",$url = "",$t_time = 3)
	{
		if(empty($url))
		{
			$url = empty($_SERVER['HTTP_REFERER']) ? '/' : $_SERVER['HTTP_REFERER'];
		}
		$this->assign("message",$message);
		$this->assign("t_url",$url);
		$this->assign("t_time",$t_time);
		$this->display("Templates/error");
	}
}