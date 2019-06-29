

<?php

/**
 * Human Behaviour
 * Sample Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

// To install php imap use:
// $ sudo apt-get install php7.2-imap
// $ sudo service apache2 restart

include_once '../core/AController.php';
include_once BASEPATH . 'model/HumanBehaviour.php';

class emailController extends AController{
	
	function GET(){
		
		parent::GET();
		$model = new HumanBehaviour();
		foreach($model->GetProperties() as $key => $value){
			$model->SetValue($key, parent::getRequest($key));
		}
		
		// $auth = parent::ValidateAutomatic('USER');
        $data = null;

        // if ($auth["Result"])
        {
            $hostname = "{mail.gordarg.com:110/pop3/notls}Inbox";
            $username = "info@gordarg.com";
            $password = '.+uVJ8Pu?WI7L+Zw$]b-T?$T';
            $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to GordMail: ' . imap_last_error());
            $emails = imap_search($inbox,'ALL');
            if($emails) {
                $output = '';
                rsort($emails);
                foreach($emails as $email_number) {
                    $message = (imap_fetchbody($inbox,$email_number,1.1)); 
                    if($message == '')
                    {
                        $message = (imap_fetchbody($inbox,$email_number,1));
                    }
                    $array = explode("\n", $message);
                }
                print_r($array);
            }
            imap_close($inbox);
        }
		
		parent::setData($emails);
		parent::returnData();
	}

}

$emailcontroller = new emailController();
?>