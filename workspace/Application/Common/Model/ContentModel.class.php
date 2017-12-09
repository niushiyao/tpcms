<?php
namespace Common\Model;

class ContentModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'news_content';
		parent::__construct($this->_table);
	}
}