<?php
namespace core;

include_once BASEPATH . 'core/Authorization.php';
include_once BASEPATH . 'core/Cryptography.php';

class Authentication{

    private $authUsername = '';
    private $authPassword = '';

    function __construct($username = null, $password = null)
    {
        if ($username == null)
        {
            $functionalitiesInstance = new functionalities();
            $this->authUsername = Functionalities::IfExistsIndexInArray($_SESSION, 'PHP_AUTH_USER');
            $this->authPassword = Functionalities::IfExistsIndexInArray($_SESSION, 'PHP_AUTH_PW');
        }
        else
        {
            $this->authUsername = $username;
            $this->authPassword = $password;
        }
    }

    function Login($path  = null){

        $db = new database_connection();
        $conn  = $db->open();
        
        $username_safe = mysqli_real_escape_string($conn, $this->authUsername);
        $password_safe = mysqli_real_escape_string($conn, $this->authPassword);

        $password_hash = Cryptography::Hash($password_safe);

        // Login
        $login_query = "SELECT `Id`, `Role` FROM `users` WHERE `Username`='" . $username_safe . "' AND `Password`='" . $password_hash . "';";
        $login_result = mysqli_query($conn, $login_query);
        $login_num = mysqli_num_rows($login_result);

        if ($login_num == 1)
        {
            $login = mysqli_fetch_array($login_result);
            if ($path != null)
            {
                $authorization = new authorization();
                if ($authorization->validate($path, $login["Role"]))
                    return $login;
                if ($path == (config::Url_PATH . "/" . 'post.php'))
                {
                    $functionalitiesInstance = new functionalities();
                    $path = $path . '|' . Functionalities::IfExistsIndexInArray($_GET, 'type');
                    if ($authorization->validate($path, $login["Role"]))
                        return $login;
                }
                return null;
            }
            else
                return $login;
        }
        return null;
    }
}

?>