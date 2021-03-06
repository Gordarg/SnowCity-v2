<?php

/**
 * Ticket
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

include_once '../core/AController.php';
include_once BASEPATH . 'model/Ticket.php';

class ticketController extends AController{
	
	function GET(){
		
		parent::GET();
		$model = new Ticket();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		
		$auth = parent::ValidateAutomatic('USER');
		$data = null;
		
		if ($auth["Result"])
			// Selecting all tickets
			if (parent::getRequest('Id') == null)
			{
				if ($auth['UserRole'] >= 3)
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `ReplyId` IS NULL");
				else
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `ReplyId` IS NULL AND `UserId`='" . $auth['UserID'] . "'");
			}

			// Reading a ticket with replies
			else
			{
				if ($auth['UserRole'] >= 3)
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE `Id`=". parent::getRequest('Id') . " OR `ReplyId`=". parent::getRequest('Id') . "");
				else
					$data = $model->Select(-1 , -1, 'Id', 'DESC', "WHERE (`Id`=". parent::getRequest('Id') . " OR `ReplyId`=". parent::getRequest('Id') . ") AND `UserId`='" . $auth['UserID'] . "'");
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
			$model = new Ticket();	
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

			$model = new Ticket();	
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

$ticketcontroller = new ticketController();
?>