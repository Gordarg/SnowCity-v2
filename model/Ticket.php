<?php
/**
 * Ticket
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class Ticket extends AModel
{

	function __construct()
	{
		self::SetTable('tickets');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			'Id' => NULL,
			'Title' => NULL,
			'IsDeleted' => '0',
			'IsClosed' => '0',
			'Priority' => 3,
			'SenderEmail' => NULL,
			'Message' => NULL,
			'File' => NULL,
			'DepartmentId' => NULL,
			'SubmitDate' => date("Y/m/d h:i:s"),
			'AdminId' => NULL,
			'ValidationCode' => Functionalities::GenerateGUID(),
			'IsValid' => '0',
			'EmailId' => NULL,
			)
		);
	}
}
?>