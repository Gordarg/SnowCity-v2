<?php

include('../core/AController.php');
include('../model/Post.php');

class postController extends AController{

	function GET(){
		parent::GET();
		$data = $model->Select();
		parent::setData($data);
		parent::returnData();
	}

	function POST(){ 
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