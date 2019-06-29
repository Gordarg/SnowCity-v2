<?php
include_once BASEPATH . 'core/AModel.php';

class Log extends AModel
{

	function __construct()
	{
		self::SetTable('logs');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id' => NULL,
			'Event' => 'LOGIN',
			'Key' => 'USERNAME',
			'Value' => 'USERTOKEN',
			'Submit' => DATETIMENOW,
		));
	}
}
?>