<?php
/**
 * Departments
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class Department extends AModel
{

	function __construct()
	{
		self::SetTable('departments');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			'Id'=>NULL,
			'Name'=>NULL,
			'IsPrivate'=>'0',
			)
		);
	}
}
?>