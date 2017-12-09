<?php
/**
* 公用的方法文件
*/


/**
* 公共返回方法
* @param bool $status true|false
* @param string $message 返回信息
* @param array $data 返回数据
* @return json json数据
*/
function show($status = '',$message = '',$data = array())
{
	$result = array(
		'status' => $status,
		'message' => $message,
		'data' => $data
	);
	echo json_encode($result);exit;
}

/**
* MD5加密方法
* @param $password 密码
* @author niushiyao
* @date  2016-09-11
*/
function getMd5Pwd($password)
{
	return md5($password . C("MD5_PRE"));
}

/**
* 菜单类型
* @author niushiyao
* @date   2016-09-15
*/
function getMenuType($type)
{
	return $type == 1 ? '后台菜单' : '前台导航';
}

/**
* 状态值
* @author niushiyao
* @date   2016-09-15
*/
function getStatus($status)
{
	switch($status)
	{
		case 0:
			return '关闭';
		case 1:
			return '正常';
		case -1:
			return '删除';
	}
}

/**
* 获得菜单是否高亮
* @author niushiyao
* @date   2016-09-22
*/
function getActive($navc)
{
	$c = strtolower(CONTROLLER_NAME);
	if(strtolower($navc) == $c)
	{
		return 'class="active"';
	}
	return '';
}

/**
* Kindediter上传图片返回方法
* @author niushiyao
* @date   2016-09-28
*/
function showEditor($status,$data)
{
	header("Content-Type:application/json;charset=utf-8");
	if($status)
	{
		exit(json_encode(array('error' => 0,'url' => $data)));
	}
	exit(json_encode(array('error' => 1,'message' => $data)));
}

/**
* 返回登录用户的相关信息
* @author niushiyao
* @date   2016-10-06
*/
function getUserInfo($field = '')
{
	$userInfo = session("adminUser");
	if(empty(($userInfo))) return false;
	return empty($field) ? $userInfo : $userInfo[$field];
}

/**
* 获得前台的栏目名称
* @author niushiyao
* @date   2016-10-06
*/
function getCateName($catArr,$catid)
{
	foreach($catArr as $val)
	{
		if($val['menu_id'] == $catid)
		{
			return $val['name'];
			exit;
		}
	}
}

/**
* 获得来源
* @author niushiyao
* @date   2016-10-06
*/
function getCopyFromById($copyID)
{
    $copyFromArr = C("COPY_FROM");
    return $copyFromArr[$copyID];
}