<?php
include_once BASEPATH . 'model/User.php';
include_once BASEPATH . 'core/Authorization.php';
include_once BASEPATH . 'core/Cryptography.php';

class Authentication
{

    public static function Login($Username, $Password){

		$model = new User();
		$model->SetValue("Username", $Username);
		$model->SetValue("HashPassword", "✓");
        $data = $model->Select(-1 , 1)[0];
		if (Cryptography::Hash($Password) == $data['HashPassword'])
		{
            // TODO: Set token for future validations
            unset($data["HashPassword"]);
            return $data;
        }
        return false;
    }
}

?>