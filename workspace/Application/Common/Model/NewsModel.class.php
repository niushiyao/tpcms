<?php
namespace Common\Model;

class NewsModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'news';
		parent::__construct($this->_table);
	}
}