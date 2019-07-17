<?php
include_once BASEPATH . 'core/AModel.php';

class User extends AModel
{

	function __construct()
	{
		self::SetTable('users');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id' => NULL,
			'Username' => NULL,
			'HashPassword' => NULL,
			'IsActive' => 1,
			'Role' => 1, // 1: VSTOR, 2:EDTOR, 3:ADMIN
		));
	}
}
?>