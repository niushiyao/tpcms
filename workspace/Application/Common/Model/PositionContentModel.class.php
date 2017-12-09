<?php
namespace Common\Model;

class PositionContentModel extends BaseModel{
	private $_table = '';
	function __construct()
	{
		$this->_table = 'position_content';
		parent::__construct($this->_table);
	}
	
}