<?php
/**
 * 后台推荐位相关
 */
namespace Admin\Controller;
use Think\Controller;
class PositionController extends CommonController {
    
    /**
	* 推荐位列表页
	* @author niushiyao
	* @return
	*/
    public function index()
    {
		$condition = ' 1=1 AND status != -1 ';
    	$page = I("p",1,'int');
    	$pageSize = 10;
    	
    	//类型搜索
    	$search_name = I("name",'','string');
    	if($search_name)
    	{
			$condition.=" AND name like '%$search_name%'";
		}
		$this->assign('search_name',$search_name);
    	
   		$PositionCount = D("Position")->get_count($condition);
    	$PositionList = D("Position")->get_page_list($condition,"*","id DESC",$page,$pageSize);
    	
		//分页方法
		$pageClass = new \Think\Page($PositionCount,$pageSize);
		$page_html = $pageClass->show();
		$this->assign('page_html',$page_html);
		
		$this->assign('PositionList',$PositionList);
    	$this->display("Position/index");
    }
	
	/**
	* 添加推荐位的方法
	* @author niushiyao
	* @return
	*/
    public function add() {
    	if(IS_POST)
    	{
			$this->_check_params(I('post.'));
			$PositionId = D('Position')->add(I('post.'));
			if($PositionId)
			{
				show(true,'添加成功',$PositionId);
			}else{
				show(false,'添加失败');
			}
		}
		
    	$this->display();
    }
    
    /**
	* 修改推荐位的方法
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
		$condition['id'] = $id;
		$Position_info = D("Position")->get_rows($condition);
		$this->assign("position_info",$Position_info);
		
		//保存提交
		if(IS_POST)
		{
			$this->_check_params(I("post."));
			$result = D('Position')->save($condition,I('post.'));
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
	* 删除推荐位的操作
	* @param id ID
	* @author niushiyao
	*/
	public function setStatus()
    {
		$Position_id = I("post.id",0,'int');
		if(!$Position_id)
		{
			show(false,'缺少ID');
		}
		
		$condition['id'] = $Position_id;
		$result = D('Position')->save($condition,array("status" =>I('post.status')));
		if($result)
		{
			show(true,'删除成功',$result);
		}else{
			show(false,'删除失败');
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
			show(false,'推荐位名不能为空');
		}
	}
}