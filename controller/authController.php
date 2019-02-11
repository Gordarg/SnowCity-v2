<?php
include_once '../core/Initialize.php';
include_once BASEPATH . 'core/AController.php';
include_once BASEPATH . 'model/User.php';
include_once BASEPATH . 'core/Authentication.php';

class authController extends AController{

	// TODO: Validate login tokens here
	function GET($Role = 'VSTOR'){
		parent::GET($Role = 'VSTOR');
		parent::setData('');
		parent::returnData();
    }

	// Login with username and password
	function POST($Role = 'VSTOR'){
		parent::POST($Role = 'VSTOR');
		parent::setData(
			Authentication::Login(
				parent::getRequest("Username")
				, parent::getRequest("Password")
			)
		);
		parent::returnData();
    }
    
}

$auth = new authController();