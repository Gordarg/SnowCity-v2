<?php
include_once '../core/AController.php';
include_once BASEPATH . 'model/User.php';

class userController extends AController{
	
	function GET(){
		parent::GET();
		$model = new User();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		$auth = parent::ValidateAutomatic('ADMIN');
		$data = null;
		if ($auth["Result"])
			$data = $model->Select(-1 , -1, 'IsActive DESC, Id', 'DESC');
		else if ($model->GetProperties()['Username'] == $auth['Username'])
			$data = $model->Select(-1 , -1, 'IsActive DESC, Id', 'DESC', "WHERE Username='" . $auth['Username'] . "'");
		parent::setData($data);
		parent::returnData();
	}

	function POST(){
		parent::POST();
		$auth = parent::ValidateAutomatic('ADMIN');
		if ($auth["Result"] || $auth['Username'] == parent::getRequest($key) )
		{
			$user = new User();	
			foreach($user->GetProperties() as $key => $value){
				$user->SetValue($key, 
					(parent::getRequest($key) == null) ? $value : parent::getRequest($key)
				);
			}
			$user->Insert();
			parent::setData($user->GetProperties());
		}
		parent::returnData();
	}

	function PUT()
	{
		// TODO: Authorize
		parent::PUT();
		$auth = parent::ValidateAutomatic('ADMIN');
		if ($auth["Result"] || $auth['Username'] == parent::getRequest('previousUsername') )
		{
			$user = new User();
			foreach($user->GetProperties() as $key => $value){
				if (parent::getRequest($key) == null)
					continue;
				$user->SetValue($key, parent::getRequest($key));
				$user->SetOperand($key);
			}
			$user->Update(parent::getRequest("previousUsername"));
			parent::setData($user->GetProperties());
		}
		parent::returnData();
	}

	function DELETE()
	{
		// TODO: Authorize
		parent::DELETE();
		$auth = parent::ValidateAutomatic('ADMIN');
		if ($auth["Result"] || $auth['Username'] == parent::getRequest('Username') )
		{
			$user = new User();
			$user->SetValue("Username", parent::getRequest("Username"));
			$user->Delete();
			parent::setData($user->GetProperties());
		}
		parent::returnData();
	}
}

$user = new userController();
?>