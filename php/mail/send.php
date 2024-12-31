<?php error_reporting(2); 
require 'phpmailerautoload.php';
require 'class.phpmailer.php';
require 'class.smtp.php';

/*define('SMTP_HOST','mail.modelsbazaar.com');
define('SMTP_USERNAME','info@modelsbazaar.com');
define('SMTP_PASSWORD','Info@321');
define('SMTP_PORT','25');
*/
define('SMTP_HOST','smtp.gmail.com');
define('SMTP_USERNAME','support@mallify.in');
define('SMTP_PASSWORD','Tui901mall10!');
//define('SMTP_PORT','25');
define('SMTP_PORT','587');
  
send_email();


function send_email($data=array())
{
    
  //echo "Send Email here";
  $subject=isset($data['subject'])?$data['subject']:"Testing";
  $body=isset($data['body'])?$data['body']:"Testing";
  $sender=isset($data['sender'])?$data['sender']:"Testing 123";
  $sender_name=isset($data['sender_name'])?$data['sender_name']:"Testing 123";
  $attachmentArray=isset($data['attachments'])?$data['attachments']:"";
  
 // print_r($data);
  
 if($sender!="" && $sender_name!="" && $subject!="" && $body!="")
 {   
   //  echo "Sender".$sender;
   $sender="puneetthakkar7@gmail.com";
    $mail = new PHPMailer;      
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = SMTP_HOST;                       // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = SMTP_USERNAME;                   // SMTP username
    $mail->Password = SMTP_PASSWORD;               // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = SMTP_PORT;                                    //Set the SMTP port number - 587 for authenticated TLS
    $mail->setFrom("orders@mallify.in", 'Mallify');     //Set who the message is to be sent from
    $mail->addReplyTo("orders@mallify.in", 'Mallify');  //Set an alternative reply-to address
    $mail->addAddress($sender, $sender_name);  // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = '<b>'.$body.'</b>';
    $mail->AltBody = strip_tags($body);
    /*$mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
        ); */
     //Add Attachment   
    if(is_array($attachmentArray) && count($attachmentArray>0)){
       foreach($attachmentArray as $attachment){
        if($attachment!="" && file_exists(ATTACHMENT_URL.$attachment))
        {
         $mail->addAttachment(ATTACHMENT_URL.$attachment);         // Add attachments file.txt     
        }   
        
       }
    }   
     
    $mail->msgHTML($body); 
    if(!$mail->send()) {
       echo 'Message could not be sent.';
       echo 'Mailer Error: ' . $mail->ErrorInfo;
       //exit;
    }else{
     echo "Send";
    }

 }
 

 
}

 

     
 
 
?>