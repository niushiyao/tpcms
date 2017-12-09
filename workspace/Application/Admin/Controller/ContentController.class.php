<?php
/**
 * 后台菜单相关
 */
namespace Admin\Controller;
use Think\Controller;
class ContentController extends CommonController {
    
    /**
	* 菜单列表页
	* @author niushiyao
	* @return
	*/
    public function index()
    {
    	//获得前端栏目、颜色和来源
		$this->_public_part();
		
		//获取推荐位列表
    	$PositionList = D("Position")->getPositionList();
    	$this->assign('positionList',$PositionList);

    	//条件搜索
    	$condition = ' 1=1 AND status != -1 ';
    	$page = I("p",1,'int');
    	$pageSize = 10;
    	
    	//栏目搜索
    	$catid = I("catid",0,'int');
    	if($catid)
    	{
			$condition.=" AND catid = $catid";
		}
		$this->assign('catid',$catid);
		
		//标题搜索
		$title = I("title",'','strip_tags');
    	if($title)
    	{
			$condition.=" AND title like '%$title%'";
		}
		$this->assign('title',$title);
    	
   		$newsCount = D("News")->get_count($condition);
    	$newsList = D("News")->get_page_list($condition,"*","news_id DESC,listorder DESC",$page,$pageSize);

		//分页方法
		$pageClass = new \Think\Page($newsCount,$pageSize);
		$page_html = $pageClass->show();
		$this->assign('page_html',$page_html);


		
		$this->assign('newsList',$newsList);
    	$this->display();
    }
	
	/**
	* 添加菜单的方法
	* @author niushiyao
	* @return
	*/
    public function add() 
    {
    	if(IS_POST)
    	{
    		$postData = I("post.");
			$this->_check_params($postData);
			
			$content = htmlspecialchars($postData['content']);
			
			//添加信息主表数据
			unset($postData['content']);
			$newsData = $postData;
			$newsData['create_time'] = time();
			$newsData['username'] = getUserInfo('username');
			$news_id = D("News")->add($newsData);
			
			if($news_id)
			{
				//添加内容表数据
				$contentData['content'] = $content;
				$contentData['news_id'] = $news_id;
				$contentData['create_time'] = time();
				$content_id = D("Content")->add($contentData);
				
				if($content_id)
				{
					show(true,'添加成功');
				}else{
					show(false,'新闻表添加成功但内容表添加失败');
				}
			}else{
				show(false,'添加失败');
			}
		}
		
    	//获得前端栏目、颜色和来源
		$this->_public_part();

    	$this->display();
    }
    
    /**
	* 编辑功能
	* @author niushiyao
	* @date   201610-06
	* @return
	*/
	public function edit()
	{
		$id = I("get.id",0,"int");
		if(!$id)
		{
			show(false,'缺少ID');
		}
		
		//获得该条信息
		$condition['news_id'] = $id;
		
		//保存提交
		if(IS_POST)
		{
			$postData = I("post.");
			$this->_check_params($postData);
			
			$content = htmlspecialchars($postData['content']);

			//添加信息主表数据
			unset($postData['content']);
			$newsData = $postData;
			$newsData['update_time'] = time();
			$newsData['username'] = getUserInfo('username');
			$news_id = D("News")->save($condition,$newsData);
			
			if($news_id)
			{
				//添加内容表数据
				$contentData['content'] = $content;
				$contentData['update_time'] = time();
				$content_id = D("Content")->save($condition,$contentData);
				if($content_id)
				{
					show(true,'编辑成功');
				}else{
					show(false,'新闻表添加成功但内容表编辑失败');
				}
			}else{
				show(false,'编辑失败');
			}
		}
		
		$news_info = D("News")->get_rows($condition);
		$content_info = D("Content")->get_rows($condition);
		$this->assign("news_info",$news_info);
		$content_info['content'] = htmlspecialchars_decode($content_info['content']);
		$this->assign("content_info",$content_info);
		
		//获得前端栏目、颜色和来源
		$this->_public_part();
		
		$this->display();
	}
	
	/**
	* 删除功能
	* @author niushiyao
	* @date   2016-10-06
	* @return
	*/
	public function setStatus()
	{
		$news_id = I("post.id",0,'int');
		if(!$news_id)
		{
			show(false,'缺少ID');
		}

		$condition['news_id'] = $news_id;
		$news_res = D('News')->save($condition,array("status" =>I('post.status')));
		if($news_res)
		{
			show(true,'删除成功',$news_res);
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
		$news_id = I("post.id",0,'int');
		$condition['news_id'] = $news_id;
		$result = D('News')->save($condition,array("listorder" =>$listorder));
		if($result)
		{
			show(true,'修改成功',$result);
		}else{
			show(false,'修改失败');
		}
	}
	
	/**
	* 推送到推荐位
	* @author niushiyao
	* @date   2016-10-07
	* @return
	*/
	public function push()
	{
		$position_id = I("post.position_id",0,'int');
		$news_ids = I("post.news_ids");
		if(!$position_id)
		{
			show(false,"请选择推荐位");
		}
		if(!$news_ids)
		{
			show(false,"请选择文章");
		}
		
		$news_ids_str = implode(",",$news_ids);
		$condition = "news_id in($news_ids_str)";
		
		//修改News表
		$res = D("News")->save($condition,array("posids" =>$position_id));
		
		//修改position_content表，添加数据
		foreach($news_ids as $val)
		{
			$news_info = D("News")->get_rows(array("news_id" => $val));
			
			//判断position_content表里在该推荐位下有无该数据
			$has_position_content = D("PositionContent")->get_rows(array("position_id" => $position_id,'news_id' => $val));
			
			$postData['position_id'] = $position_id;
			$postData['title'] = $news_info['title'];
			$postData['thumb'] = $news_info['thumb'];
			$postData['news_id'] = $val;
			
			if($has_position_content)
			{
				//有该数据则更新
				$postData['update_time'] = time();
				$position_res = D('PositionContent')->save(array("id" => $has_position_content['id']),$postData);
			}else{
				//无该数据则添加
				$postData['create_time'] = $news_info['create_time'];
				$position_res = D('PositionContent')->add($postData);
			}
		}
		
		if($res && $position_res)
		{
			show(true,"推荐成功");
		}elseif(!$res && $position_res){
			show(true,"推荐内容更新成功");
		}else{
			show(false,"推荐失败");
		}
	}
    
    /**
	* 检查元素
	* @author niushiyao
	* @date   2016-10-06
	*/
	private function _check_params($postData)
	{
		if(!isset($postData['title']) || empty($postData['title']))
		{
			show(false,'标题名不能为空');
		}
		if(!isset($postData['thumb']) || empty($postData['thumb']))
		{
			show(false,'缩略图不能为空');
		}
		if(!isset($postData['catid']) || empty($postData['catid']))
		{
			show(false,'所属栏目不能为空');
		}
		if(!isset($postData['content']) || empty($postData['content']))
		{
			show(false,'内容不能为空');
		}
		if(!isset($postData['description']) || empty($postData['description']))
		{
			show(false,'简介不能为空');
		}
	}
	
	/**
	* 公共部分
	* @auhor niushiyao
	* @date  2016-10-06
	*/
	private function _public_part()
	{
		//获得前端的栏目
    	$frontMeun = D("Menu")->getFrontMenus();
    	$this->assign('frontMenu',$frontMeun);
    	
    	//获得颜色
    	$titleFontColor = C('TITLE_FONT_COLOR');
    	$this->assign('titleColor',$titleFontColor);

    	//获得来源
    	$copyFrom = C("COPY_FROM");
    	$this->assign('copyFrom',$copyFrom);
	}
    
}
