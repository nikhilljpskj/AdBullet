<?php session_start(); 

include('curl/CurlRequest.php');
$curl=new CurlRequest;

  # code...
  function sendMail($phone){
    $mail = new PHPMailer;      
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'letscomparemail@gmail.com';                   // SMTP username
    $mail->Password = 'czjdlslexxhxwqga';               // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = '587';                                    //Set the SMTP port number - 587 for authenticated TLS
    $mail->setFrom("letscomparemail@gmail.com");     //Set who the message is to be sent from
    $mail->addAddress('samarth@spaceboat.in');  // Add a recipient
    $mail->Subject = 'Lead From Google Ads';
    $mail->Body    = $phone;
    $mail->send();
  }

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
         parse_str($_POST["formData"], $_POST);
       
        $phone = isset($_POST["mobile"])?$_POST["mobile"]:"";
        if($phone==""){
          $phone = isset($_POST["Pmobile"])?$_POST["Pmobile"]:"";
        }
         
        $cookie_campaign_id=isset($_COOKIE['secureCmpID'])?$_COOKIE['secureCmpID']:"";        
        $cookie_content_id=isset($_COOKIE['secureContentID'])?$_COOKIE['secureContentID']:"";        
        $cookie_keywords=isset($_COOKIE['secureKeywords'])?$_COOKIE['secureKeywords']:"";       
     
        $gclid = isset($_POST["gclid"])?$_POST["gclid"]:"";
        $campaign= (isset($_POST["campaign"]) && $_POST["campaign"]!="")?$_POST["campaign"]:$cookie_campaign_id;
        $content = (isset($_POST["content"]) && $_POST["content"]!="")?$_POST["content"]:$cookie_content_id;
        $keywords = (isset($_POST["keywords"]) && $_POST["keywords"]!="")?$_POST["keywords"]:$cookie_keywords;

       //print_r($_POST);
        
if($phone!=""){

 $domain="purvanchalcnst.letscompare.in";
 
$execUrl="http://adbullet.in/php/api.php";
$mobile="9999909770";//Client
//$mobile="8285039708";//Gopal Sir
$smsMsg="Dear New Query - Mobile number is $phone From Aria Regards Vserve";

//send_sms($mobile,'',$smsMsg);
$c=$curl->get($execUrl,array('domain'=>$domain,'msg'=>$smsMsg,'mobile'=>$mobile,'action'=>'msg'));
 //print_r($c);
 //exit;

$leadData['name']='NA';
$leadData['phone']=$phone;
$leadData['company']='Internet';
$leadData['page']=$page='https://www.letscompare.in/holiday/index.php';
$leadData['email']='';
$leadData['remarks']='Internet';
$leadData['campaign']=$campaign;
$leadData['keywords']=$keywords;
$leadData['gclid']=$gclid;
$leadData['content']=$content;

//print_r($leadData);
$c=$curl->get($execUrl,array('domain'=>$domain,'leadData'=>$leadData,'action'=>'saveLead'));

$fileMsg='##########################
<table>
<tr><th>Mobile - </th><td>'.$phone.'</td></tr>
<tr><th>Camp - </th><td>'.$campaign.'</td></tr>
    <tr><th>Date-Time - </th><td>'.date('Y-m-d H:i:s').'</td></tr>
</table>
######################
  ';
  
//$fh = fopen($filename, 'a') or die("can't open file");
$getContent=file_get_contents('mailsent.html');
$content=$fileMsg."\n \n".$getContent;
file_put_contents("mailsent.html", $content);
fclose($fh);

$_SESSION["isUserSaved"]='saved';
 
}

}

function send_sms($mobile='',$from='Lcmpre',$link='',$mode='develop')
{
    $smsmsg=$link!=""?$link:"";
    
    if($smsmsg!="")
    {
            $from='vserve';   
            $msg=$smsmsg;

            $data=http_build_query(['UserID'=>'comparedthapi','Password'=>'sday7394SD','SenderID'=>'VSEREC','Phno'=>'91'.$mobile,'Msg'=>$msg]);
            $url='http://nimbusit.biz/api/SmsApi/SendSingleApi?'.$data;
           //$url='https://nimbusit.biz/api/SmsApi/SendSingleApi?UserID=t1Silverstroke&Password=11980226&SenderID=MODELB&Phno='.$mobile.'&Msg='.$msg;
            $ch = curl_init($url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           $response = curl_exec($ch);
           print_r($response);
          
           // $url="http://203.212.70.200/smpp/sendsms?username=comparedthapi&password=del12345&to=".$mobile."&from=".$from."&text=".$msg."&udh=&dlr-mask=19&dlr-url=".HTTP_ROOT."dishtvoff1.php?myid=Comp123&status=1&updated_on=%25t%26&res=%252";
           // $url="http://sms6.routesms.com:8080/bulksms/bulksms?username=vserveecom&password=ab4cv34x&type=0&dlr=1&destination=".$mobile."&source=".$from."&message=$msg";
        //   $ch='';
         //echo  $url='http://nimbusit.biz/api/SmsApi/SendSingleApi?UserID=comparedthapi&Password=sday7394SD&SenderID=TXTOTP&Phno='.$mobile.'&Msg='.$msg;
          
          // $arrContextOptions=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false,),);  
           //$contents = file_get_contents($url, false, stream_context_create($arrContextOptions));
          // $array = json_decode(json_encode((array)simplexml_load_string(utf8_encode($contents))),true);
         
           // $ch = curl_init($url);
            //curl_setopt($ch,CURLOPT_URL,$url);
            //curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

            //$output=curl_exec($ch);
            //curl_close($ch);
           // return $output;
    }
}


 ?>