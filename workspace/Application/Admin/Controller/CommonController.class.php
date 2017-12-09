<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class CommonController extends Controller {

	public function __construct() {
		
		parent::__construct();
		$this->_init();
		$this->getAdminMenu();
	}
	
	/**
	 * 初始化
	 * @return
	 */
	private function _init() {
		// 如果已经登录
		$isLogin = $this->isLogin();
		if(!$isLogin) {
			// 跳转到登录页面
			//$this->redirect('/admin.php?c=login');
		}

		//网站域名
		$this->assign("server_name",C("SERVER_NAME"));
	}

	/**
	 * 获取登录用户信息
	 * @return array
	 */
	public function getLoginUser() {
		return session("adminUser");
	}

	/**
	 * 判定是否登录
	 * @return boolean 
	 */
	public function isLogin() {
		$user = $this->getLoginUser();
		if($user && is_array($user)) {
			return true;
		}
		return false;
	}
	
	/**
	* 获取后台菜单列表
	* @author niushiyao
	* @date   2016-09-22
	*/
	public function getAdminMenu()
	{
		$condition = 'status != -1 AND type = 1';
		$adminMenus = D("Menu")->get_list($condition,"*","listorder DESC, menu_id DESC");
		$this->assign('adminMenus',$adminMenus);
	}
}