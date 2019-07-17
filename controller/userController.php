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
			// $user->SetValue("Role", 1);
			// $user->SetValue("IsValidPhoneNumber", 'off');
			// $user->SetValue("IsValidEmail", 'off');
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
			$data = true;

			$user = new User();
			foreach($user->GetProperties() as $key => $value){

				$user->SetValue('Id', $auth['UserID']);

				if (parent::getRequest($key) == null)
					continue;
				$user->SetValue($key, parent::getRequest($key));
				$user->SetOperand($key);

				if (parent::getRequest("HashPassword") != null)
				{
					$data = Authentication::Login(
						parent::getRequest('previousUsername')
						, parent::getRequest('Current')
					);
					if ($data)
						$user->SetValue('Id', $data['Id']);
				}
			}

			if (!$data) parent::setStatus(403);
			else $user->Update();

			$user->ClearOperands("HashPassword");
			$user->ClearHeavyAllowed("HashPassword");
			$result = $user->Select(-1 , -1, 'Id', 'DESC', "WHERE Id='" . $user->GetProperties()['Id'] . "'");
			foreach($user->GetProperties() as $key => $value)
				if (Functionalities::IfExistsIndexInArray($result[0], $key))
					$user->SetValue($key, $result[0][$key]);

			

			parent::setData($user->GetProperties());
		}
		else parent::setStatus(403);

		
		parent::returnData();
	}
}

$user = new userController();
?>