

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
        $data = [];

        // if ($auth["Result"])
        {
            $hostname = "{mail.gordarg.com:110/pop3/notls}Inbox";
            $username = "info@gordarg.com";
            $password = '.+uVJ8Pu?WI7L+Zw$]b-T?$T';
            $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to GordMail: ' . imap_last_error());
            $emails = imap_search($inbox,'ALL');
            if($emails) {
                rsort($emails);
                foreach($emails as $email_number) {
                    $header = imap_fetchheader($inbox,$email_number,1.1); 
                    $message = imap_fetchbody($inbox,$email_number,1.1);
                    $headerinfo = imap_headerinfo($inbox, $email_number);
                    
                    if($message == '')
                    {
                        $header = imap_fetchheader($inbox,$email_number,1); 
                        $message = imap_fetchbody($inbox,$email_number,1);
                        $headerinfo = imap_header($inbox, $email_number);
                    }

                    $email_sender = Functionalities::ExtractEmails(htmlentities($headerinfo->senderaddress))[0];
                    $email_toaddress = Functionalities::ExtractEmails(htmlentities($headerinfo->toaddress));
                    $email_date = $headerinfo->date;
                    $email_size = $headerinfo->Size;
                    // $email_cc = $headerinfo->ccaddress;
                    // $email_bcc = $headerinfo->bccaddress;
                    // $email_refrences = $headerinfo->references;
                    $email_messageid = htmlentities($headerinfo->message_id);
                    $email_inreplyto = @htmlentities($headerinfo->in_reply_to);
                    $email_deleted = ($headerinfo->Deleted == 'D') ? true : false;
                    $email_unseen = ($headerinfo->Unseen == 'U') ? true : false;
                    
                    print ("<pre>");
                    print ($email_inreplyto);
                    print ("<br/>");
                    print ($email_sender);
                    print ("<br/>");
                    print (join(' ', $email_toaddress));
                    print ("<br/>");
                    print ($email_messageid);
                    print ("<br/><br/><br/>");
                    print ($message);
                    print ("</pre>");
                    print ("<hr/>");


                    $raw = $header . $message;
                    array_push($data, $raw);
                    // print("============================");
                }
            }
            imap_errors();
            imap_alerts();
            imap_close($inbox);
        }
		
        parent::setData($data);
        
        
		// parent::returnData();
	}

}

$emailcontroller = new emailController();
?>