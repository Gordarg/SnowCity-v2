<?php

include('../core/AController.php');
include('../model/Post.php');

class postController extends AController{

	function HEAD(){
		parent::setData();
	}

	function GET(){
		Authentication::ValidateAutomatic(['VSTOR', 'EDTOR', 'ADMIN']);
		// TODO: Authorize
		parent::GET();
		// TODO: Validations must be done in public side and api side
		$model = new User();
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
		$post = new User();	
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