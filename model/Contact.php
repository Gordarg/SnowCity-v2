<?php
/**
 * Ticket
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class Contact extends AModel
{

	function __construct()
	{
		self::SetTable('contacts');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			'Id' => NULL,
			'UserId'=>NULL,
			'Type'=>'email',
			'Value'=>'a@b.c',
			)
		);
	}
}
?>