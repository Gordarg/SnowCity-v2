<?php

include_once '../core/AController.php';
include_once BASEPATH . 'model/User.php';
include_once BASEPATH . 'core/Authentication.php';

class authController extends AController{

	// TODO: Validate login tokens here
	function GET(){
		parent::GET();
		parent::setData(
			Authentication::Validate(
				parent::getRequest("Id"),
				parent::getRequest("Username"),
				parent::getRequest("Token"),
				parent::getRequest("Role")
			)
		);
		parent::returnData();
	}

	// Login with username and password
	function POST(){
		parent::POST();
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