<?php

include_once '../core/AController.php';
include_once BASEPATH . 'model/PostDetail.php';

class postdetailController extends AController{

	function GET(){
		parent::ValidateAutomatic('VSTOR');
		// TODO: Authorize
		parent::GET();
		// TODO: Validations must be done in public side and api side
		$model = new PostDetail();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		$data = $model->Select(-1 , -1, 'Submit', 'DESC');
		if (parent::getRequest('Type') != null)
			$data = $model->Select(-1 , -1, 'Submit', 'DESC', "WHERE `Type` = '" . parent::getRequest('Type') . "'");
		parent::setData($data);
		parent::returnData();
	}
}

$post = new postdetailController();
?>