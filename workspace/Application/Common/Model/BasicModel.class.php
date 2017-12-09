<?php
namespace Common\Model;

class BasicModel extends BaseModel{
	
	function __construct()
	{
		
	}
	
	/**
	* 基本信息保存方法
	* @author niushiyao
	* @return
	*/
	public function save_basic_info($postData)
	{
		$res = F("web_basic_config",$postData);
		return $res;
	}
	
	/**
	* 获取基本信息
	* @author niushiyao
	* @return
	*/
	public function get_basic_info()
	{
		return F('web_basic_config');
	}
}