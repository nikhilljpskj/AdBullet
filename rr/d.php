<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');
 $postdata = file_get_contents("php://input");
 session_start();
 $id=session_id();
 $isActive=isset($_GET['isActive'])?$_GET['isActive']:"";
 $enterValue=isset($_GET['enterValue'])?$_GET['enterValue']:"";
 $submitForm=isset($_GET['submitForm'])?$_GET['submitForm']:"";
 $user_id=isset($_GET['user_id'])?$_GET['user_id']:"";
 $mobile=isset($_GET['m'])?$_GET['m']:"";
 $page_id=isset($_GET['page_id'])?$_GET['page_id']:"";
 $os=isset($_GET['os'])?$_GET['os']:"";
 $nav=isset($_GET['nav'])?$_GET['nav']:"";
 $ref=isset($_GET['ref'])?$_GET['ref']:"";
 $city=isset($_GET['city'])?$_GET['city']:"";
 $state=isset($_GET['state'])?$_GET['state']:"";
 date_default_timezone_set('Asia/Kolkata');
      $a=json_decode($postdata);


      function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
      }
      
        $visitUrl=$url=isset($a->events[2]->data->href)?$a->events[2]->data->href:"";
        if($visitUrl==""){
                $visitUrl=$url=isset($a->events[0]->data->href)?$a->events[0]->data->href:"";
                if($visitUrl==""){
                        $visitUrl=$url=isset($a->events[1]->data->href)?$a->events[1]->data->href:"";

                }
        }
        $visitWidth=isset($a->events[2]->data->width)?$a->events[2]->data->width:"";
        if($visitWidth==""){
                $visitWidth=isset($a->events[0]->data->width)?$a->events[0]->data->width:"";
                if($visitWidth==""){
                        $visitWidth=isset($a->events[1]->data->width)?$a->events[1]->data->width:"";

                }
       
        }
        $visitHeight=isset($a->events[2]->data->height)?$a->events[2]->data->height:"";
        if($visitHeight==""){
                $visitHeight=isset($a->events[0]->data->height)?$a->events[0]->data->height:"";
                if($visitHeight==""){
                        $visitHeight=isset($a->events[1]->data->height)?$a->events[1]->data->height:"";

                }
        }
       
        $startTime=isset($a->events[0]->timestamp)?$a->events[0]->timestamp:"";
        $startTime=$startTime>0?round(($startTime/1000)):$startTime;
        

        $totalEvents=isset($a->events)?count($a->events):"";
        $endTime=isset($a->events[$totalEvents-1]->timestamp)?$a->events[$totalEvents-1]->timestamp:"";
        $endTime=$endTime>0?round(($endTime/1000)):$endTime;
        //$ipAddress=isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:"";

       
        if($endTime>$startTime && $url!=""){
        $visitUrl = preg_replace('/\?.*/', '', $visitUrl);

        $query_params=array();
        $queryPrams = parse_url($url);
        parse_str($queryPrams['query'], $query_params);
                

        $campaign=isset($query_params['campaign'])?$query_params['campaign']:"";
        $keyword=isset($query_params['keyword'])?$query_params['keyword']:"";
        $network=isset($query_params['network'])?$query_params['network']:"";
        $gclid=isset($query_params['gclid'])?$query_params['gclid']:"";
        
        $ipAddress=get_client_ip();
        
        $city=isset($_SESSION['mycity'])?$_SESSION['mycity']:'';
        $state=isset($_SESSION['mystate'])?$_SESSION['mystate']:'';
   


        if($state==''){
        $baseUrl='https://geolocation-db.com/jsonp/2218d160-dc35-11e9-be30-db04ad88bc45/'.$ipAddress;
        $location = file_get_contents($baseUrl);
        // [country_code] => IN [country_name] => India [city] => New Delhi [postal] => 110014 
        //[latitude] => 28.6 [longitude] => 77.2 [IPv4] => 103.57.85.105 [state] => National Capital Territory of Delhi
         $locationArr=json_decode($location,true);
         $city=isset($locationArr['city'])?$locationArr['city']:'';
         $state=isset($locationArr['state'])?$locationArr['state']:'';
         $_SESSION['mycity']=$city;
         $_SESSION['mystate']=$state;
        }




        
        $differenceInSeconds = $endTime - $startTime;
        $minutes = floor(($differenceInSeconds / 60) % 60);
        
        $encodeUrl=base64_encode($visitUrl);

       
        ### Save Sessions
        $mysqli = new mysqli("localhost", "brandscoot", "Brandscoot@654321", "recordings");

        $mysqli -> query("SELECT * FROM orders where user_id='".$id."' and short_url='".$visitUrl."' limit 1");
        $total_rows=$mysqli -> affected_rows;
        $isActiveDB=$isActive=="no"?0:1;
        $enterValueDB=$enterValue=="no"?0:1;
        $submitFormDB=$submitForm=="no"?0:1;

        if($total_rows==0){
             
                $sql = "INSERT INTO orders (`user_id`,   nav, os, mobile, full_url, mouse_move, enter_value, submit_form, total_seconds, total_mins, ip_address, short_url, campaign, keyword, city, state ,screen_height, screen_width, ref_url,created_at)
                VALUES ('$id', '$nav', '$os', '$mobile', '$url', '$isActiveDB', '$enterValueDB', '$submitFormDB', '$differenceInSeconds', '$minutes', '$ipAddress', '$visitUrl', '$campaign','$keyword','$city','$state','$visitHeight','$visitWidth','$ref','".date('Y-m-d H:i:s')."')";    
                $mysqli->query($sql); 
        }else{
                $sql="UPDATE orders set `city`='$city', `state`='$state', mouse_move='$isActiveDB', enter_value='$enterValueDB', submit_form='$submitFormDB',  total_seconds='$differenceInSeconds', total_mins='$minutes', updated_at = '".date('Y-m-d H:i:s')."'  where user_id='".$id."' and short_url='".$visitUrl."' ";
                $mysqli->query($sql); 

        }

        $postSessionData=array('nav'=>$nav,'mobile'=>$mobile,'ref'=>$ref,'os'=>$os,'session_id'=>$id,'user_id'=>$user_id,'page_id'=>$page_id,'url'=>$url,'isActive'=>$isActive,'enterValue'=>$enterValue,'submitForm'=>$submitForm,'totalSeconds'=>$differenceInSeconds,'totalMinutes'=>$minutes,'ip_address'=>$ipAddress,'visitUrl'=>$visitUrl,'campaign'=>$campaign,'keyword'=>$keyword,'network'=>$network,'gclid'=>$gclid,'visitWidth'=>$visitWidth,'visitHeight'=>$visitHeight,'startTime'=>$startTime,'totalEvents'=>$totalEvents,'endTime'=>$endTime);
        
        //$fileName=strtotime(date('Y-m-d H:i:s'));
        $file = '/home/thetigergroove/public_html/rr/sessions/'.$id.'_'.$encodeUrl.'.json';
        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new person to the file
        $current = json_encode($postSessionData);
        
        // Write the contents back to the file
        file_put_contents($file, $current);

        $mysqli->close();

        


//$fileName=strtotime(date('Y-m-d H:i:s'));
$file = '/home/thetigergroove/public_html/rr/recordings/'.$id.'_'.$encodeUrl.'.json';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current = $postdata;
// Write the contents back to the file
file_put_contents($file, $current);

        }

?>