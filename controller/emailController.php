<?php

/**
 * Email
 * Tickets Plugin
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

// To install php imap use:
// $ sudo apt-get install php7.2-imap
// $ sudo service apache2 restart

include_once '../core/AController.php';
include_once BASEPATH . 'model/Email.php';
include_once BASEPATH . 'model/Ticket.php';

class emailController extends AController{
    
    // This function is only accessable by admin
    // to view email inbox, delete them, etc ...
	function GET(){
		
		parent::GET();
        
        $data = [];

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
                $email_subject = $headerinfo->subject;
                $email_messageid = htmlentities($headerinfo->message_id);
                $email_inreplyto = @htmlentities($headerinfo->in_reply_to);
                $email_deleted = ($headerinfo->Deleted == 'D') ? true : false;
                $email_unseen = ($headerinfo->Unseen == 'U') ? true : false;
                
                $message_normal = preg_replace('/(^\w.+:\n)?(^>.*(\n|$))+/mi', '', $message);

                // Insert to emails table
                $model = new Email();
                $model->SetValue('RAW', $header.$message);
                $model->SetValue('Title', $email_subject);
                $model->SetValue('MessageId', $email_messageid);
                $model->SetValue('ReplyId', $email_inreplyto);
                $model->SetValue('Sender', $email_sender);
                $model->SetValue('Date', $email_date);
                $model->SetValue('Message', urlencode($message));
                $model->SetValue('MessageNormal', $message_normal);
                $result = $model->Insert();

                $email_model_id = $model->GetProperties()['Id'];
                
                // TODO: This if doesnt work!
                if ($result instanceof Exception)
                {
                    // parent::setData($result);
                    // parent::returnData();
                }
                else
                {
                    // Insert to tickets table
                    $model = new Ticket();
                    $model->SetValue('Title', $email_subject);
                    $model->SetValue('SenderEmail', $email_sender);
                    $model->SetValue('Message', $message);
                    // $model->SetValue('File', );
                    $model->SetValue('EmailId', $email_model_id);
                    $result = $model->Insert();

                    // Delete email from server
                    imap_delete($inbox, $email_number, 1);
                    imap_delete($inbox, $email_number, 1.1);
                    imap_expunge($inbox);
                }
            }
        }
        // Disable imap errors print
        imap_errors();
        imap_alerts();
        imap_close($inbox);

        $auth = parent::ValidateAutomatic('USER');
        if ($auth["Result"])
        if (parent::getRequest('UserId') == null)
            if (! $auth['UserRole'] >= 3)
                parent::setStatus(403);
            else{
                // TODO: Load data from tables

                $model = new Email();
                foreach($model->GetProperties() as $key => $value){
                    $model->SetValue($key, parent::getRequest($key));
                }
                $data = $model->Select(-1 , -1, 'Id', 'DESC');              
                parent::setData($data);
            }
		parent::returnData();
    }
    
    static public function SendEmail($to, $title, $message)
    {
        // TODO: Send emails from here!
        // For example, when a ticket is sent,
        // call the user...!

        // Sent emails must be stored in database,
        // and flagged that we are the owner.
    }
}

$emailcontroller = new emailController();
?>