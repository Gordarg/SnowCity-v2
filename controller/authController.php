<?php
include('../core/AController.php');
include('../model/User.php');
include_once '../core/Authentication.php';
include_once '../core/Cryptography.php';

class authController extends AController{

	function POST($Role = 'VSTOR'){

		parent::POST($Role);
		$model = new User();
		$model->SetValue("Username", parent::getRequest("Username"));
		$model->SetValue("HashPassword", "✓");
        // $model->SetValue("HashPassword", Cryptography::Hash(parent::getRequest("Password")));
		$data = $model->Select(-1 , -1, 'IsActive DESC, Id', 'DESC');
		parent::setData($data);
		parent::returnData();
    }
    
}

$auth = new authController ();