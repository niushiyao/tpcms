<?php
namespace Common\Model;

class MenuModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'menu';
		parent::__construct($this->_table);
	}
	
	/**
	* 获得前端的栏目
	* @author niushiyao
	* @date   2016-10-06
	*/
	public function getFrontMenus()
	{
		$condition = array('status' => 1,'type' => 0);
    	$order = '`listorder` DESC,menu_id DESC';
    	$frontMeun = D("Menu")->get_list($condition,'menu_id,name',$order);
    	return $frontMeun;
	}
}