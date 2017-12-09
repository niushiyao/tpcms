<?php
namespace Common\Model;

class PositionModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'position';
		parent::__construct($this->_table);
	}
	
	/**
	* 获取推荐位的列表
	* @author niushiyao
	* @date   2016-10-07
	*/
	public function getPositionList()
	{
		$condition['status'] = array('neq',-1);
		$PositionList = D("Position")->get_list($condition,"*","id DESC");
		
		return empty($PositionList) ? false : $PositionList;
	}
}