<?php

include_once '../core/AController.php';
include_once BASEPATH . 'model/User.php';

class userController extends AController{

	function GET(){
		Authentication::ValidateAutomatic(['ADMIN']);
		// TODO: Authorize
		parent::GET();
		$model = new User();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		$data = $model->Select(-1 , -1, 'IsActive DESC, Id', 'DESC');
		parent::setData($data);
		parent::returnData();
	}

	function POST(){
		// TODO: Authorize
		parent::POST();
		$user = new User();	
		foreach($user->GetProperties() as $key => $value){
			$user->SetValue($key, 
				(parent::getRequest($key) == null) ? $value : parent::getRequest($key)
			);
		}
		$user->Insert();
		parent::setData($user->GetProperties());
		parent::returnData();
	}

	function PUT()
	{
		Authentication::ValidateAutomatic(['ADMIN','EDTOR','VSTOR']);
		// TODO: Authorize
		parent::PUT();
		$user = new User();
		foreach($user->GetProperties() as $key => $value){
			if (parent::getRequest($key) == null)
				continue;
			$user->SetValue($key, parent::getRequest($key));
			$user->SetOperand($key);
		}
		$user->Update(parent::getRequest("previousId"));
		parent::setData($user->GetProperties());
		parent::returnData();
	}

	function DELETE(){
		Authentication::ValidateAutomatic(['ADMIN']);
		// TODO: Authorize
		parent::DELETE();
		$user = new User();
		$user->SetValue("Id", parent::getRequest("Id"));
		$user->Delete();
		parent::setData($user->GetProperties());
		parent::returnData();
	}
}

$user = new userController();
?>