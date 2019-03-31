<?php
include_once BASEPATH . 'model/User.php';
include_once BASEPATH . 'core/Authorization.php';
include_once BASEPATH . 'core/Bridge.php';
include_once BASEPATH . 'core/Cryptography.php';

class Authentication
{

    public static function ValidateToken($Username, $Token){
        $model = new Log();
        // TODO: SQL INJECTION BUG ON $Username and $Token
        // Functionalities::SQLINJECTIOENCODE
        $result = $model->Select(0 , 1, 'Submit' ,'DESC',
            "WHERE `Event`='LOGIN' AND `Key`='" .
            $Username . "' AND `Value`='" . $Token . "'");
        $result_bool = Functionalities::IfExistsIndexInArray($result, 0) != false;
        return $result_bool;
    }

    public static function ValidateRole($Username, $Role){
        $model = new User();
        // TODO: SQL INJECTION BUG ON $Username and $Token
        // Functionalities::SQLINJECTIOENCODE
        $result = $model->Select(0 , 1, 'Id' ,'DESC',
            "WHERE `Username`='" . $Username . "' AND `Role`>=" . $Role);
        $result_bool = Functionalities::IfExistsIndexInArray($result, 0) != false;
        return $result_bool;
    }
    
    public static function Login($Username, $Password){
		$model = new User();
        $model->SetValue("Username", $Username);
        $model->SetValue("HashPassword", "✓");
        $result = $model->Select(-1 , 1, 'Id', 'ASC', "WHERE `Username`='" . $Username . "'");
        if (count($result) != 1)
            return false;
        $data = $result[0];
		if (Cryptography::Hash($Password) == $data['HashPassword'])
		{
            $log = Bridge::LogToDb('LOGIN', $Username, Functionalities::GenerateToken())->GetProperties();
            $data['Token'] = $log['Value'];
            unset($data["HashPassword"]);
            return $data;
        }
        return false;
    }
}

?>