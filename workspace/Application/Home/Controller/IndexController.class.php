<?php
namespace Home\Controller;
class IndexController extends BaseController {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* 网站首页
	* @author niushiyao
	* @date   2016-10-15
	* @return
	*/
    public function index($type = '')
    {
		//焦点图
		$jiaodian_pic = D("PositionContent")->get_list(array("position_id" => 2,"status" => 1),"news_id,title,thumb","listorder DESC","1");
		$this->assign("jiaodian_pic",$jiaodian_pic);

		//小图推荐
		$small_pic = D("PositionContent")->get_list(array("position_id" => 3,"status" => 1),"news_id,title,thumb","listorder DESC","3");
		$this->assign("small_pic",$small_pic);

		//文章列表
		$articles = D("News")->get_list(array("status" => 1,"thumb"=>array("neq","")),"news_id,title,thumb,description,keywords,create_time","listorder DESC","10");
		$this->assign('articles',$articles);

		//右侧部分
		$this->common_right();

		//生成网页静态化
		if($type == 'buildhtml')
		{
			$this->buildHtml("index",HTML_PATH,'Index/index');
		}else{
			$this->display();
		}
    }

	/**
	 * 首页生成静态页面
	 * @author niushiyao
	 * @date   2016-11-13
	 */
	public function build_html()
	{
		$this->index("buildhtml");
		show(true,'首页生成成功');
	}
	/**
	 * 栏目列表页面
	 * @author niushiyao
	 * @date   2016-10-15
	 */
	public function catlist()
	{
		$cateID = I("get.id",0,"int");
		if(empty($cateID))
		{
			$this->show_error("没有栏目ID");
		}

		$page = I("p",1,'int');
		$pageSize = 10;

		//文章列表
		$condition = array("status" => 1,"catid" => $cateID,"thumb" => array("neq",""));
		$fields = "news_id,title,thumb,description,keywords,create_time";
		$articles_count = D("News")->get_count($condition);
		$articles = D("News")->get_page_list($condition,$fields,"listorder DESC",$page,$pageSize);
		$this->assign('articles',$articles);

		//分页方法
		$pageClass = new \Think\Page($articles_count,$pageSize);
		$page_html = $pageClass->show();
		$this->assign('page_html',$page_html);

		//右侧部分
		$this->common_right();

		$this->display();
	}

	/**
	 * 详情页面
	 * @author niushiyao
	 */
	public function detail()
	{
		$newsId = I("get.id",0,"int");
		if(empty($newsId))
		{
			$this->show_error("没有新闻ID");
		}
		
		$condition = array("news_id" => $newsId);
		$news_detail = D("News")->get_rows($condition,"title");
		$news_content = D("Content")->get_rows($condition,"content");
		$news_detail['content'] = htmlspecialchars_decode($news_content['content']);
		$this->assign("news_detail",$news_detail);

		//浏览数加1
		D("News")->setIncPlus($condition);

		//右侧部分
		$this->common_right();
		$this->display("Index/detail");
	}

	/**
	 * 预览功能
	 * @author niushiyao
	 * @date   2016-10-19
	 */
	public function preview()
	{
		if(empty(getUserInfo()))
		{
			$this->show_error("登录才能访问！");
		}
		$this->detail();
	}

	/**
	 * 右侧部分
	 * @author niushiyao
	 * @date   2016-10-15
	 */
	public function common_right()
	{
		//文章排行
		$article_order = D("News")->get_list(array("status" => 1),"news_id,title,description","count DESC, listorder Desc","10");
		$this->assign("article_order",$article_order);

		//广告位
		$ads_news_right = D("PositionContent")->get_list(array("position_id" => 5,"status" => 1),"news_id,thumb","listorder DESC","2");
		$this->assign("ads_news_right",$ads_news_right);
	}
}