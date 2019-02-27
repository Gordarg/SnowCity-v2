<?php

include_once '../core/AController.php';
include_once BASEPATH . 'model/Post.php';

class postController extends AController{

	function VIEW(){
		parent::VIEW();
		$model = new Post();
		parent::setData($model->GetProperties());
		parent::returnData();
	}

	function GET(){
		Authentication::ValidateAutomatic(['VSTOR', 'EDTOR', 'ADMIN']);
		// TODO: Authorize
		parent::GET();
		$model = new Post();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		$data = $model->Select(-1 , -1, 'Submit', 'DESC');
		parent::setData($data);
		parent::returnData();
	}

	function POST(){
		Authentication::ValidateAutomatic(['EDTOR', 'ADMIN']);
		// TODO: Authorize
		parent::POST();
		$post = new Post();	
		foreach($post->GetProperties() as $key => $value){
			$post->SetValue($key, 
				(parent::getRequest($key) == null) ? $value : parent::getRequest($key)
			);
		}
		$post->Insert();
		parent::setData($post->GetProperties());
		parent::returnData();
	}

	function PUT()
	{
		Authentication::ValidateAutomatic(['EDTOR', 'ADMIN']);
		// TODO: Authorize
		parent::PUT();
		$post = new Post();
		foreach($post->GetProperties() as $key => $value){
			if (parent::getRequest($key) == null)
				continue;
			$post->SetValue($key, parent::getRequest($key));
			$post->SetOperand($key);
		}
		$post->Update(parent::getRequest("previousId"));
		parent::setData($post->GetProperties());
		parent::returnData();
	}

	function DELETE(){
		Authentication::ValidateAutomatic(['EDTOR', 'ADMIN']);
		// TODO: Authorize
		parent::DELETE();
		$post = new Post();
		$post->SetValue("Id", parent::getRequest("Id"));
		$post->Delete();
		parent::setData($post->GetProperties());
		parent::returnData();
	}
}

$post = new postController();
?>