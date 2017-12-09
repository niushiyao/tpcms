<?php
namespace Common\Model;

class AdminModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'admin';
		parent::__construct($this->_table);
	}
}