<?php
/**
 * 后台基本信息相关
 */
namespace Admin\Controller;
use Think\Controller;
class BasicController extends CommonController {
    
    /**
	* 基本信息页
	* @author niushiyao
	* @date   2016-10-07
	*/
    public function index()
    {
    	$basic_info = D("Basic")->get_basic_info();
    	$this->assign('basic_info',$basic_info);
    	$this->display();
    }
    
    /**
	* 基本信息保存页面
	* @author niushiyao
	* @date   2016-10-07
	*/
	public function add()
	{
		if(IS_POST)
    	{
    		$postData = I('post.');
			$this->_check_params($postData);
			D('Basic')->save_basic_info($postData);
			show(true,'配置成功');
		}
	}

	/**
	 * @param $postData 提交的参数
	 * @author niushiyao
	 * @date   2016-11-13
	 */
	private function _check_params($postData)
	{
		if(!isset($postData['title']) || empty($postData['title']))
		{
			show(false,'站点标题不能为空');
		}
		if(!isset($postData['keywords']) || empty($postData['keywords']))
		{
			show(false,'站点关键字不能为空');
		}
	}

	/**
	 * 缓存配置
	 * @author niushiyao
	 * @date   2016-11-13
	 */
	public function cache()
	{
		$this->display("cache");
	}
}