<?php
/**
 * Human Behaviour
 * Sample Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once BASEPATH . 'core/AModel.php';

class HumanBehaviour extends AModel
{

	function __construct()
	{
		self::SetTable('human-behaviour');
		self::SetPrimaryKey('Id');
		self::SetPrimaryKeyType('Int');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
			'Id'=>NULL,
			'Year'=>date('Y'),
			'Month'=>date('m'),
			'Day'=>date('d'),
			'From'=>NULL,
			'To'=>NULL,
			'Quality'=>NULL,
			'Task'=>NULL,
			'Brief'=>NULL,
			'UserId'=>NULL,
			)
		);
	}
}
?>