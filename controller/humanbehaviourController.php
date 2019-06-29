<?php

/**
 * Human Behaviour
 * Sample Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once '../core/AController.php';
include_once BASEPATH . 'model/HumanBehaviour.php';

class humanbehaviourController extends AController{
	
	function GET(){
		
		parent::GET();
		$model = new HumanBehaviour();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		
		$auth = parent::ValidateAutomatic('USER');

		$data = null;
		
		if ($auth["Result"])
			if (parent::getRequest('UserId') == null)
				if ($auth['UserRole'] >= 3)
					$data = $model->Select(-1 , -1, 'Id', 'DESC');
				else
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `UserId`='" . $auth['UserID'] . "'");
			else
				if ($auth['UserRole'] >= 3)
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `UserId`='" . parent::getRequest('UserId') . "'");
				else if (parent::getRequest('UserId') == $auth['UserID'])
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `UserId`='" . $auth['UserID'] . "'");
		
		parent::setData($data);
		parent::returnData();
	}

	function POST(){
		parent::POST();

		$auth = parent::ValidateAutomatic('USER');
		
		if (
			($auth["Result"] && $auth['UserRole'] >= 3)
			||
			($auth['UserID'] == parent::getRequest('UserId')) )
		{

			$model = new HumanBehaviour();	
			foreach($model->GetProperties() as $key => $value){
				$model->SetValue($key, 
					(parent::getRequest($key) == null) ? $value : parent::getRequest($key)
				);
			}

			
			$result = $model->Insert();

			if ($result instanceof Exception)
				parent::setData($result);
			else
				parent::setData($model->GetProperties());
			parent::returnData();
		}
		parent::returnData();
	}


	function DELETE(){
		parent::DELETE();

		$auth = parent::ValidateAutomatic('USER');
		
		if (
			($auth["Result"] && $auth['UserRole'] >= 3)
			||
			($auth['UserID'] == parent::getRequest('UserId')) )
		{

			$model = new HumanBehaviour();	
			foreach($model->GetProperties() as $key => $value){
				$model->SetValue($key, 
					(parent::getRequest($key) == null) ? $value : parent::getRequest($key)
				);
			}
			
			$result = $model->Delete();
			if ($result instanceof Exception)
				parent::setData($result);
			else
				parent::setData($model->GetProperties());
			parent::returnData();
		}
		parent::returnData();
	}

}

$humanbehaviourcontroller = new humanbehaviourController();
?>