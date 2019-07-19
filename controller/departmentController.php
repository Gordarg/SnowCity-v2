<?php

/**
 * Department
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once '../core/AController.php';
include_once BASEPATH . 'model/Department.php';

class departmentController extends AController{
	
	function GET(){
		
		parent::GET();
		$model = new Department();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		
		$auth = parent::ValidateAutomatic('USER');
		$data = null;
        
        
        if ($auth["Result"])
        if ($auth['UserRole'] >= 2)
        {
			if (parent::getRequest('Id') != null)
                $data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `Id`=". parent::getRequest('Id'));
            else
                $data = $model->Select(-1 , -1, 'Id', 'DESC', "");
        }
        else
        {
            if (parent::getRequest('Id') != null)
                $data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `IsPrivate`=0 AND `Id`=". parent::getRequest('Id'));
            else
                $data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `IsPrivate`=0" );
        }

			
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
			$model = new Department();	
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

			$model = new Department();	
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

$departmentcontroller = new departmentController();
?>