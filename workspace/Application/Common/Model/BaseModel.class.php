<?php
namespace Common\Model;
use Think\Model;

class BaseModel extends Model{
	
	private $_db = '';
	function __construct($table)
	{
		$this->_db = M($table);
	}
	
	/**
	* 获得表中的某一条数据
	* @param $condition 条件
	* @param $fields 字段
	* @author niushiyao
	* @date   2016-09-11
	*/
	public function get_rows($condition = array(),$fields = '*')
	{
		$res = $this->_db->field($fields)->where($condition)->find();
		return $res;
	}

	/**
	* 获得某个表的多条数据
	* @param undefined $condition
	* @param undefined $fields
	* @param undefined $order
	* @param undefined $page
	* @param undefined $pageSize
	* 
	* @return
	*/
	public function get_list($condition = array(),$fields = '*',$order = '', $limit = '')
	{
		$list = $this->_db->field($fields)->where($condition)->order($order)->limit($limit)->select();
		return $list;
	}
	
	/**
	* 
	* @param undefined $data
	* 
	* @return
	*/
	public function get_page_list($condition = array(),$fields = '*',$order = '',$page = 1,$pageSize = 10)
	{
		$offset = ($page-1)*$pageSize;
		$list = $this->_db->field($fields)->where($condition)->order($order)->limit($offset,$pageSize)->select();
		return $list;
	}
	
	/**
	* 获得条件下的总数
	* @param array $condition
	* @author niushiyao
	* @return int
	*/
	public function get_count($condition = array())
	{
		$count = $this->_db->where($condition)->count();
		return $count;
	}
	
	/**
	* 添加表中的一条数据
	* @author niushiyao
	*/
	public function add($data)
	{
		if(empty($data)) return false;
		$res = $this->_db->data($data)->add();
		return $res;
	}
	
	/**
	* 根据ID编辑表中的数据
	* @param  $id ID
	* @param  $data 数组
	* @author niushiyao
	* @date   2016-09-17
	*/
	public function save($condition = array(),$data)
	{
		if(empty($condition)) return false;
		$res = $this->_db->where($condition)->data($data)->save();
		return $res;
	}

	/**
	 * 浏览数加1
	 * @author niushiyao
	 * @date   2016-10-19
	 */
	public function setIncPlus($condition = array(),$field = "count")
	{
		if(empty($condition)) return false;
		$res = $this->_db->where($condition)->setInc($field, 1);
		return $res;
	}
}