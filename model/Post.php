<?php
include_once BASEPATH . 'core/AModel.php';



class Post extends AModel
{

    // TODO: Access levels must be validated in model level
    // Other Validations are based on
    // Circles, Types, Roles,
    // Refrence ID, ...

	function __construct()
	{
		self::SetTable('posts');
		self::SetProperties(array(
			// 'KEY' => DEFAULT_VALUE,
            'MasterId' => Functionalities::GenerateGUID(),
            'Id' => NULL,
            'Title' => '',
            'Submit' => constant("DATETIMENOW"),
            'Type' => NULL,
            'Level' => 1,
            'BinContent' => NULL,
            'Body' => '',
            'UserId' => NULL,
            'Status' => 'SENT',
            'Language' => 'en-us',
            'RefrenceId' => NULL,
            'Index' => '0',
            'IsDeleted' => '0',
            'IsContentDeleted' => '0',
		));
	}
}
?>