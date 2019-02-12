<?php
include_once BASEPATH . 'model/User.php';
include_once BASEPATH . 'core/Authorization.php';
include_once BASEPATH . 'core/Cryptography.php';

class Authentication
{
    public static function Validate($Id, $Username, $Token, $Role){
        // TODO: Validate token with database
        return true;
    }

    public static function Login($Username, $Password){

		$model = new User();
		$model->SetValue("Username", $Username);
		$model->SetValue("HashPassword", "✓");
        $data = $model->Select(-1 , 1)[0];
		if (Cryptography::Hash($Password) == $data['HashPassword'])
		{
            // TODO: Set token for future validations
            $data['Token'] = 'abc';
            unset($data["HashPassword"]);
            return $data;
        }
        return false;
    }
}

?>