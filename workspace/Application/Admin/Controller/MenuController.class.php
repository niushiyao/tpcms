<?php
/**
 * 后台菜单相关
 */
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {
    
    /**
	* 菜单列表页
	* @author niushiyao
	* @return
	*/
    public function index()
    {
		$condition = ' 1=1 AND status != -1 ';
    	$page = I("p",1,'int');
    	$pageSize = 10;
    	
    	//类型搜索
    	$menu_type = I("type",-1,'int');
    	if($menu_type > -1)
    	{
			$condition.=" AND type = $menu_type";
		}
		$this->assign('type',$menu_type);
    	
   		$menuCount = D("Menu")->get_count($condition);
    	$menuList = D("Menu")->get_page_list($condition,"*","menu_id DESC",$page,$pageSize);
    	
		//分页方法
		$pageClass = new \Think\Page($menuCount,$pageSize);
		$page_html = $pageClass->show();
		$this->assign('page_html',$page_html);
		
		$this->assign('menuList',$menuList);
    	$this->display("Menu/index");
    }
	
	/**
	* 添加菜单的方法
	* @author niushiyao
	* @return
	*/
    public function add() {
    	if(IS_POST)
    	{
			$this->_check_params(I('post.'));
			$menuId = D('Menu')->add(I('post.'));
			if($menuId)
			{
				show(true,'添加成功',$menuId);
			}else{
				show(false,'添加失败');
			}
		}
		
    	$this->display();
    }
    
    /**
	* 修改菜单的方法
	* @param undefined $postData
	* @author niushiyao
	*/
	public function edit()
	{
		$id = I("get.id",0,"int");
		if(!$id)
		{
			show(false,'缺少ID');
		}
		
		//获得该条信息
		$condition['menu_id'] = $id;
		$menu_info = D("Menu")->get_rows($condition);
		$this->assign("menu_info",$menu_info);
		
		//保存提交
		if(IS_POST)
		{
			$this->_check_params(I("post."));
			$result = D('Menu')->save($condition,I('post.'));
			if($result)
			{
				show(true,'编辑成功',$result);
			}else{
				show(false,'编辑失败');
			}
		}
		
		$this->display();
	}
	
	/**
	* 删除菜单的操作
	* @param id ID
	* @author niushiyao
	*/
	public function setStatus()
    {
		$menu_id = I("post.id",0,'int');
		if(!$menu_id)
		{
			show(false,'缺少ID');
		}
		
		$condition['menu_id'] = $menu_id;
		$result = D('Menu')->save($condition,array("status" =>I('post.status')));
		if($result)
		{
			show(true,'删除成功',$result);
		}else{
			show(false,'删除失败');
		}
	}
	
	/**
	* 排序方法
	* @author niushiyao
	* @date   2016-09-22 
	* @return
	*/
	public function listorder()
	{
		$listorder = I("post.listorder",0,"int");
		$menu_id = I("post.id",0,'int');
		$condition['menu_id'] = $menu_id;
		$result = D('Menu')->save($condition,array("listorder" =>$listorder));
		if($result)
		{
			show(true,'修改成功',$result);
		}else{
			show(false,'修改失败');
		}
		
	}
	
    /**
	* 必填项验证方法
	* @author niushiyao
	*/
	private function _check_params($postData)
	{
		if(!isset($postData['name']) || empty($postData['name']))
		{
			show(false,'菜单名不能为空');
		}
		if(!isset($postData['m']) || empty($postData['m']))
		{
			show(false,'模块名不能为空');
		}
		if(!isset($postData['c']) || empty($postData['c']))
		{
			show(false,'控制器名不能为空');
		}
		if(!isset($postData['f']) || empty($postData['f']))
		{
			show(false,'方法名不能为空');
		}
	}
}