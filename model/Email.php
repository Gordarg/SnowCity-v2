<?php
/**
 * Emails
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class Email extends AModel
{

	function __construct()
	{
		self::SetTable('emails');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id'=>NULL,
			'ReceiveDate'=>date("Y/m/d h:i:s"),
			'RAW'=>NULL,
			'MessageId'=>NULL,
			'ReplyId'=>NULL,
			'Sender'=>NULL,
			'Date'=>NULL,
			'Message'=>'',
			'MessageNormal'=>'',
			)
		);
	}
}
?>