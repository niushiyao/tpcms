<?php
/**
 * 后台推荐位内容相关
 */
namespace Admin\Controller;
use Think\Controller;
class PositioncontentController extends CommonController {
    
    /**
	* 推荐位内容列表页
	* @author niushiyao
	* @return
	*/
    public function index()
    {
		$condition = ' 1=1 AND status != -1 ';
    	$page = I("p",1,'int');
    	$pageSize = 10;
    	
    	//获取推荐位列表
    	$PositionList = D("Position")->getPositionList();
    	$this->assign('positionList',$PositionList);

    	//推荐位搜索
    	$posid = I("posid",0,'int');
    	if($posid)
    	{
			$condition.=" AND position_id = $posid";
		}
		$this->assign('posid',$posid);
		
		//标题搜索
		$search_title = I("title",'','string');
    	if($search_title)
    	{
			$condition.=" AND title like '%$search_title%'";
		}
		$this->assign('search_title',$search_title);

   		$PositioncontentCount = D("PositionContent")->get_count($condition);
    	$PositioncontentList = D("PositionContent")->get_page_list($condition,"*","id DESC",$page,$pageSize);
    	
		//分页方法
		$pageClass = new \Think\Page($PositioncontentCount,$pageSize);
		$page_html = $pageClass->show();
		$this->assign('page_html',$page_html);
		
		$this->assign('PositionContentList',$PositioncontentList);
    	$this->display();
    }
	
	/**
	* 添加推荐位内容的方法
	* @author niushiyao
	* @return
	*/
    public function add() {
    	
    	//获取推荐位列表
    	$PositionList = D("Position")->getPositionList();
    	$this->assign('positionList',$PositionList);
    	
    	if(IS_POST)
    	{
    		$postData = I('post.');
			$this->_check_params($postData);
			
			if(!$postData['thumb'] && $postData['news_id'])
			{
				//将该条新闻的缩略图赋值
				$condition['news_id'] = $postData['news_id'];
				$news_info = D("News")->get_rows();
				$postData['thumb'] = $news_info['thumb'];
			}
			$postData['create_time'] = time();
			$PositioncontentId = D('PositionContent')->add($postData);
			if($PositioncontentId)
			{
				show(true,'添加成功',$PositioncontentId);
			}else{
				show(false,'添加失败');
			}
		}
		
    	$this->display();
    }
    
    /**
	* 修改推荐位内容的方法
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
		$Positioncontent_info = D("PositionContent")->get_rows($condition);
		$this->assign("content_info",$Positioncontent_info);
		
		//获取推荐位列表
    	$PositionList = D("Position")->getPositionList();
    	$this->assign('positionList',$PositionList);
    	
		//保存提交
		if(IS_POST)
    	{
    		$postData = I('post.');
			$this->_check_params($postData);
			
			if(!$postData['thumb'] && $postData['news_id'])
			{
				//将该条新闻的缩略图赋值
				$con['news_id'] = $postData['news_id'];
				$news_info = D("News")->get_rows($con);
				$postData['thumb'] = $news_info['thumb'];
			}
			$postData['update_time'] = time();
			$PositioncontentId = D('PositionContent')->save($condition,$postData);
			if($PositioncontentId)
			{
				show(true,'修改成功',$PositioncontentId);
			}else{
				show(false,'修改失败');
			}
		}
		
		$this->display();
	}
	
	/**
	* 删除推荐位内容的操作
	* @param id ID
	* @author niushiyao
	*/
	public function setStatus()
    {
		$Positioncontent_id = I("post.id",0,'int');
		if(!$Positioncontent_id)
		{
			show(false,'缺少ID');
		}
		
		$condition['id'] = $Positioncontent_id;
		$result = D('PositionContent')->save($condition,array("status" =>I('post.status')));
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
	* @date   2016-10-07
	* @return
	*/
	public function listorder()
	{
		$listorder = I("post.listorder",0,"int");
		$content_id = I("post.id",0,'int');
		$condition['id'] = $content_id;
		$result = D('PositionContent')->save($condition,array("listorder" =>$listorder));
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
		if(!isset($postData['title']) || empty($postData['title']))
		{
			show(false,'标题名不能为空');
		}
		if(!isset($postData['position_id']) || empty($postData['position_id']))
		{
			show(false,'请选择推荐位');
		}
	}
}