<?php
include('../core/AController.php');
include('../model/User.php');
include_once '../core/Authentication.php';
include_once '../core/Cryptography.php';

class authController extends AController{


	// Login with username and password
	function POST(){
		parent::POST();
		$model = new User();
		$model->SetValue("Username", parent::getRequest("Username"));
		$model->SetValue("HashPassword", "✓");
		$data = $model->Select(-1 , 1)[0];
		if (Cryptography::Hash(parent::getRequest("Password")) == $data['HashPassword'])
		{
			unset($data["HashPassword"]);
			parent::setData($data);
		}
		parent::returnData();
    }
    
}

$auth = new authController();