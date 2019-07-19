<?php
/**
 * Staffs
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class Staff extends AModel
{

	function __construct()
	{
		self::SetTable('staffs');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
            'Id' => NULL,
			'UserId'=>NULL,
			'DepartmentId'=>NULL,
			)
		);
	}
}
?>