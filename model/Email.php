<?php
/**
 * Emails
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class HumanBehaviour extends AModel
{

	function __construct()
	{
		self::SetTable('emails');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id'=>NULL,
			'ReceiveMonth'=>date('m'),
			'ReceiveDay'=>date('d'),
			'RAW'=>NULL,
			'MessageId'=>NULL,
			'ReplyId'=>NULL,
			'Sender'=>NULL,
			'Date'=>0,
			'Task'=>'',
			'Brief'=>'',
			'UserId'=>NULL,
			)
		);
	}
}
?>