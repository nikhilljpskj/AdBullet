<?php 

 
require 'phpmailerautoload.php';
require 'class.phpmailer.php';
require 'class.smtp.php';
/*$senderCon=getenv('SENDER_EMAIL');
$subject=getenv('EMAIL_SUBJECT');
$body=getenv('EMAIL_BODY');
$attachments=getenv('ATTACHMENTS');
$is_attachment=getenv('IS_ATTACHMENT');
if($attachments!=""){
  $attachmentArray=explode('$$',$attachments);  
}
$senderArray=explode('$$',$senderCon);
*/

 /*if(mail('puneetthakkar7@gmail.com', 'Test email', 'Test email with standard mail() function')) {
  echo 'Mail sent';
 }


  else echo 'Mail sending failed';
  exit; */
  
   $emailto = 'puneetthakkar7@gmail.com';
$emailsubject = "You got a quiry";
$emailmessage = "Test";
$emailfrom = "puneetthakkar7@gmail.com";
 
 
/*$myArray=unserialize($argv[1]);  
$newarray=array_merge($myArray,array('yo'=>"2","asdsd"=>"2"));

echo json_encode($newarray);
 exit;
        */
$senderArray=array('Enquiry'=>'enquiry@bestway.in','puneet thakkar'=>'puneetthakkar7@gmail.com','Bestway Info'=>'info@bestway2india.com');
$body="Test";
$subject='Test';
if(is_array($senderArray) && count($senderArray)>0 && $body!="" && $subject!="")
{
    
    
 foreach($senderArray as $senderAr)
 { 
     if($senderAr!="")
     {
         
         //echo $senderAr;
            $mail = new PHPMailer;      
            $mail->SMTPDebug = 3;
            $mail->isSMTP();                                      // Set mailer to use SMTP
            //$mail->isMail();
            
         //   $mail->Host = 'localhost';                       // Specify main and backup server
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
           // $mail->Host = 'mail.bestway.in';                       // Specify main and backup server
            //$mail->Host = 'mail.letscompare.in';                       // Specify main and backup server
            //$mail->Host = 'mail.bigescapades.com';                       // Specify main and backup server
            $mail->SMTPAuth = true;                               // Enable SMTP authentication

           // $mail->SMTPAuth = false;
            //$mail->SMTPSecure = false;

            //$mail->Username = 'info@modelsbazaar.com';            // SMTP username
            //$mail->Password = 'Info@321';               // SMTP password
            
            //$mail->Username = 'care@hyve.buzz';            // SMTP username
            //$mail->Password = 'Apple123*';               // SMTP password

            //$mail->Username = 'no-reply@comparedth.net';            // SMTP username
            //$mail->Password = 'Noreply@123';               // SMTP password

            //$mail->Username = 'orders@hyve.buzz';            // SMTP username
            //$mail->Password = 'Justbewise1*';               // SMTP password
            
            $mail->Username = 'bestway@bestway.in';            // SMTP username
            $mail->Password = 'shriganesh@2400';               // SMTP password

         //   $mail->Username = 'bestway@bestway.in';            // SMTP username
         //   $mail->Password = 'shriganesh@2400';               // SMTP password

            //$mail->Username = 'online@4gm.in';            // SMTP username
            //$mail->Password = 'Apple123*';               // SMTP password

          // $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
           // $mail->protocol = 'mail';                            // Enable encryption, 'ssl' also accepted
            $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
            //$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
            //$mail->Port = 25;                                    //Set the SMTP port number - 587 for authenticated TLS
           $mail->Port = 465;
                                                //Set the SMTP port number - 587 for authenticated TLS

            $mail->setFrom('bestway@bestway.in', 'Bestway');     //Set who the message is to be sent from
            $mail->addReplyTo('bestway@bestway.in', 'Bestway');  //Set an alternative reply-to address
              
            $mail->addAddress($senderAr, '');  // Add a recipient
           // $mail->addAddress(array('suresh.kumar@bestway.in','info@bestway2india.com'));  // Add a recipient
        
            //echo MY_VAR;
            //print_r($_REQUEST);
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            /*$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
            if(isset($attachmentArray) && is_array($attachmentArray) && count($attachmentArray)>0 && $is_attachment=="YES"){
                foreach($attachmentArray as $attachmentsFile){
                  $mail->addAttachment($attachmentsFile);         // Add attachments
              
                }
            }*/
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $subject;
            $mail->AltBody = $subject;
             
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            /*$invoiceId='<table style="max-width: 100%;" border="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
            <td style="text-align: center; padding: 2px !important; height: 30px; margin-top: 3px; background-color: #fff; width: 100%;" colspan="3"><img style="width: 60px; margin: 5px auto;" src="https://www.hyve.buzz/img/Backend/emailer/emailer-logo.png" alt="" /></td>
            </tr>
            <tr style="background: #f1f1f1;">
            <td style="font-size: 14px;" colspan="3" valign="top"><br /><span style="color: black; font-family: arial;">
            <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Dear Admin,</span></p>
            <p style="text-align: left; color: black;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">New Contact Query Generated in our website </span></p>
            <p style="text-align: left; color: black;"> from ymailName - ##NAME##</p>
            <p style="text-align: left; color: black;">Email - ##EMAIL##</p>
            <p style="text-align: left; color: black;">Phone - ##PHONE##</p>
            <p style="text-align: left; color: black;">Subject - ##SUBJECT##</p>
            <p style="text-align: left; color: black;">Message - ##MESSAGE##</p>
            <p style="text-align: left; color: black;"><span style="font-family: arial, helvetica, sans-serif; font-size: small;">Warm Welcome,</span></p>
            <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif;">Team Hyve</span></p>
            <br /></span></td>
            </tr>
            <tr style="background-color: #000; height: 100px;">
            <td><a href="https://www.facebook.com/hyvemobility" target="_blank"><img style="margin: 0 2px; width: 15px;" src="https://www.hyve.buzz/img/Backend/emailer/fb_mail.jpg" alt="" /></a> <a href="https://twitter.com/HyveMobility" target="_blank"><img style="margin: 0 2px; width: 15px;" src="https://www.hyve.buzz/img/Backend/emailer/tw_mail.jpg" alt="" /></a> <a href="https://www.linkedin.com/company/hyve-mobility"><img style="margin: 0 2px; width: 15px;" src="https://www.hyve.buzz/img/Backend/emailer/li_mail.jpg" alt="" /></a> <a href="https://www.youtube.com/channel/UCYaZb8AEacf6SVsrfi53oew" target="_blank"><img style="margin: 0 2px; width: 15px;" src="https://www.hyve.buzz/img/Backend/emailer/yt_mail.jpg" alt="" /></a></td>
            <td style="text-align: center;"><span style="color: #bfbfbf; font-family: arial; font-size: x-small; display: block;">Copyright&nbsp;2016 4GM Hyve Mobility Pvt. Ltd. All rights reserved</span></td>
            <td style="text-align: right; padding-right: 10px;"><span style="color: #bfbfbf; font-family: arial; font-size: x-small;"><strong>4GM Hyve Mobility Pvt. Ltd</strong><br />M-67, First Floor,<br />Greater Kailash 2, New Delhi 110048</span></td>
            </tr>
            </tbody>
            </table>';*/
            $mail->msgHTML($body);

             
            if(!$mail->send()) {
             //  echo 'Message could not be sent.';
              echo 'Mailer Error: ' . $mail->ErrorInfo;
             //  exit;
            }
            else{
                echo "Sended to ".$senderAr.'<br />';
            }
           // exit;
             
            //echo 'Message has been sent';
     }
 }
}