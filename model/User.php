<?php
include_once BASEPATH . 'core/AModel.php';

class User extends AModel
{

	function __construct()
	{
		self::SetTable('users');
		self::SetPrimaryKey('Username');
		self::SetPrimaryKeyType('String');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id' => NULL,
			'Username' => NULL,
			'HashPassword' => NULL,
			'IsActive' => 1,
			'Role' => 'VSTOR',
		));
	}
}
?>