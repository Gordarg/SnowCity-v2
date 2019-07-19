<?php

/**
 * Staff
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once '../core/AController.php';
include_once BASEPATH . 'model/Staff.php';

class staffController extends AController{
	
	function GET(){
		
		parent::GET();
		$model = new Staff();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		
		$auth = parent::ValidateAutomatic('EDTOR');
		$data = null;
        
        if ($auth["Result"])
            if ($auth['UserRole'] >= 3)
            {
                if (parent::getRequest("DepartmentId") != null)
                    $data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `DepartmentId` = " . parent::getRequest("DepartmentId"));
            }

            // TODO: Show the owner info only
            // else
            //     $data = $model->Select(-1 , -1, 'Id', 'DESC', "");
        
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
			$model = new Staff();	
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

			$model = new Staff();	
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

$staffcontroller = new staffController();
?>