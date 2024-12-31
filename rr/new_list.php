
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-extended.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />


<?php 
ini_set('memory_limit', '1024M');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$baseUrl="https://".$_SERVER['HTTP_HOST']."/";





date_default_timezone_set('Asia/Kolkata');
$session_dir_path = "sessions/";
$getUrl=isset($_GET['url'])?$_GET['url']:"";
$getKeywords=isset($_GET['keywords'])?$_GET['keywords']:"";
$getGclid=isset($_GET['gclid'])?$_GET['gclid']:"";
$getIpAddress=isset($_GET['ip_address'])?$_GET['ip_address']:"";
$duration_in_sec=isset($_GET['duration_in_sec'])?$_GET['duration_in_sec']:"";
$camp_id=isset($_GET['camp_id'])?$_GET['camp_id']:"";
$event_type=isset($_GET['event_type'])?$_GET['event_type']:"";
$start_date=(isset($_GET['start_date']) && $_GET['start_date']!="")?$_GET['start_date']:"";
$end_date=(isset($_GET['end_date']) && $_GET['end_date']!="")?$_GET['end_date']:"";
     
$files = array(); $subFiles=array(); $tempFiles=array();  $filter_array=array();
$filter_mouseMove=array(); $filter_keywords=array(); $filter_ip_address=array(); $filter_mouse_move=array(); $filter_enter_value=array(); $filter_form_submit=array();
$filter_visit_url=array(); $filter_idle=array(); $filter_campaign=array(); $filter_gclid=array(); $filter_totalSeconds=array(); $filter_start_date=array();
$filter_end_date=array();

$scanFiles = array_diff(scandir($session_dir_path,SCANDIR_SORT_DESCENDING), array('..', '.'));
//echo "Total Scan-".count($scanFiles);

if(is_array($scanFiles) && count($scanFiles)>0){
    foreach ($scanFiles as $key=>$file) {
        if ($file != "." && $file != "..") {
          ## echo $file.'---';
           $fileTime=filectime($session_dir_path.$file);
          # echo '<br>';

           $file_parts = pathinfo($session_dir_path.$file);
           $fileContent=file_get_contents($session_dir_path.$file);
           $fileDataInArray=json_decode($fileContent,true);
           if(is_array($fileDataInArray) && count($fileDataInArray)>0){

            $sessionArray=explode('_',$file);
            $sessionName=isset($sessionArray[0])?$sessionArray[0]:"";
           
            
           if((is_array($event_type) && count($event_type)>0) || $start_date!="" || $end_date!="" || $getIpAddress!="" || $getGclid!="" || $getKeywords!="" || $getUrl!="" || $duration_in_sec!="" || $camp_id!=""){ 
           
            if($getKeywords!=""){
              if(strpos($fileDataInArray['keyword'], $getKeywords) >= 0){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_keywords[$file] = $fileTime;
                }
                
              }
            }
            if($getIpAddress!=""){
              if($fileDataInArray['ip_address']==$getIpAddress){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_ip_address[$file] = $fileTime;
                }

              }
            }

            if($start_date!="" && $end_date!=""){
              //echo strtotime(date('Y-m-d',$fileDataInArray['startTime']));
              //echo '<br>';
              //echo strtotime($end_date);
              //exit;

              if(strtotime(date('Y-m-d',$fileDataInArray['startTime']))>=strtotime($start_date)){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_start_date[$file] = $fileTime;
                }

              }

              if(strtotime(date('Y-m-d',$fileDataInArray['startTime']))<=strtotime($end_date)){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_end_date[$file] = $fileTime;
                }

              }

            }
            

            //print_r($fileDataInArray);
            //exit;
            if(is_array($event_type) && count($event_type)>0){

             if(in_array('mousemove',$event_type)){
              if(isset($fileDataInArray['isActive']) && $fileDataInArray['isActive']=="yes"){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_mouse_move[$file]=$fileTime;  
                }

              }
             }

             if(in_array('entervalue',$event_type)){
              if(isset($fileDataInArray['enterValue']) && $fileDataInArray['enterValue']=="yes"){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_enter_value[$file]=$fileTime;
                }

              }
             }

             if(in_array('formsubmit',$event_type)){
              
              if(isset($fileDataInArray['submitForm']) && $fileDataInArray['submitForm']=="yes"){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_form_submit[$file]=$fileTime;
                }

              }
             }

             if(in_array('idle',$event_type)){
              if( isset($fileDataInArray['submitForm']) && $fileDataInArray['submitForm']=="no" &&  isset($fileDataInArray['enterValue']) && $fileDataInArray['enterValue']=="no" && isset($fileDataInArray['isActive']) && $fileDataInArray['isActive']=="no"){

                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_idle[$file]=$fileTime;
                }


              }
             }
              
            }

            if($getUrl!=""){
              if($fileDataInArray['visitUrl']==$baseUrl.$getUrl){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_visit_url[$file]=$fileTime;
                }
               
              }
            }

            if($camp_id!=""){
              if($fileDataInArray['campaign']==$camp_id){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_campaign[$file]=$fileTime;
                }


  
              }
            }

            if($getGclid!=""){
              if($fileDataInArray['gclid']==$getGclid){
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_gclid[$file]=$fileTime;
                }


  
              }
            }


            if($duration_in_sec!=""){
              if($fileDataInArray['totalSeconds']==$duration_in_sec){
              
                if(in_array($sessionName,$tempFiles)){
                  $subFiles[$file] = $sessionName;
                }else{
                  array_push($tempFiles,$sessionName);
                  $filter_totalSeconds[$file]=$fileTime;
                }

              


              }
            }
            $filter=1;
          }else{
            //$fileContentInArray[$file]=$fileDataInArray;
            //echo $file.'-->'.$sessionName.'==';
            if(in_array($sessionName,$tempFiles)){
              $subFiles[$file] = $sessionName;
            }else{
              array_push($tempFiles,$sessionName);
              $files[$file] = $fileTime;
            }
             

            //print_r($files);
            //echo '<br>';
            
            
            $filter=0;
          }

           
          }

          //  if(isset($file_parts['extension']) && $file_parts['extension']=="json"){
          //   $files[filemtime($session_dir_path.$file)] = $file;
          //  }
        }
    }
    
    echo "Filter Applied-".$filter.'<br>';
    if($filter==1){
      
      //echo "Asdasd";
      $filter_array[]=$filter_campaign;
      $filter_array[]=$filter_enter_value;
      $filter_array[]=$filter_gclid;
      $filter_array[]=$filter_form_submit;
      $filter_array[]=$filter_ip_address;
      $filter_array[]=$filter_keywords;
      $filter_array[]=$filter_mouse_move;
      $filter_array[]=$filter_totalSeconds;
      $filter_array[]=$filter_visit_url;
      $filter_array[]=$filter_idle;
      $filter_array[]=$filter_start_date;
      $filter_array[]=$filter_end_date;
      $filter_array = array_filter($filter_array);
      // print_r($filter_array);
      if(count($filter_array)>1){
       
         $files=(array_intersect_key(...$filter_array));
         
      }else{
        $keys=array_keys($filter_array);
        $key=isset($keys[0])?$keys[0]:"";
         if($key>=0){
          $files=isset($filter_array[$key])?$filter_array[$key]:"";
         // print_r($files);
        }
        

      }
      //exit;
     }
    }
    
   // print_r($subFiles);
   // print_r($files);
   // exit;
    // sort
    (isset($files) && is_array($files) && count($files)>0)?arsort($files):"";
    // find the last modification
    $reallyLastModified = (isset($files) && is_array($files) && count($files)>0)?end($files):"";
  

 
 // print_r($mouseMove);
 // print_r($visit_url);
 

  //print_r($fileContentInArray);
  //exit;

// open this directory 
/*$myDirectory = opendir($dir_path);
// get each entry
$i=1;
while($entryName = readdir($myDirectory)) {
     $file_parts = pathinfo($entryName);
     if(isset($file_parts['extension']) && $file_parts['extension']=="json"){
      #  $content=file_get_contents($dir_path.$entryName);
      #  $a=json_decode($content);
      #  $visitUrl=isset($a->events[2]->data->href)?$a->events[2]->data->href:"";
      #  $visitWidth=isset($a->events[2]->data->width)?$a->events[2]->data->width:"";
      #  $visitHeight=isset($a->events[2]->data->height)?$a->events[2]->data->height:"";
      #  $startTime=isset($a->events[0]->timestamp)?$a->events[0]->timestamp:"";
      #  $totalEvents=isset($a->events)?count($a->events):"";
      #  $endTime=isset($a->events[$totalEvents-1])?$a->events[$totalEvents-1]:"";

        $dirArray[] = $entryName;
       # if($i==3) { echo count($a->events);  exit; }
       # $i++;
     }

    
}
// close directory
closedir($myDirectory);*/
//  count elements in array
$indexCount = count($files);
Print ("$indexCount files<br>\n");
// sort 'em
//sort($dirArray);
// print 'em
//print_r($files);
//exit;
?>

<table>
<form method="get" action="">  
  <tr>
    <td>Duration In Sec.</td>
    <td><input name="duration_in_sec" value="<?php echo $duration_in_sec; ?>"  type="text"></td>
  
    <td>URL</td>
    <td><input name="url"  value="<?php echo $getUrl; ?>" type="text"></td>

    <td>Keywords</td>
    <td><input name="keywords"  value="<?php echo $getKeywords; ?>" type="text"></td>

    <td>IP Address</td>
    <td><input name="ip_address"  value="<?php echo $getIpAddress; ?>" type="text"></td>

  
   
  </tr> 
  <tr>
    <td>Campaign ID</td>
    <td><input name="camp_id" value="<?php echo $camp_id; ?>"  type="text"></td>
 
    <!-- <td>Gclid</td>
    <td><input name="gclid"  value="<?php echo $getGclid; ?>" type="text"></td> -->

    <td>Events</td>
    <td><select name="event_type[]" multiple>
      <option value="">Select Event</option>
      <option <?php echo (is_array($event_type) && count($event_type)>0 && in_array('idle',$event_type))?"selected":""; ?> value="idle">IDLE</option>
      <option <?php echo (is_array($event_type) && count($event_type)>0 && in_array('mousemove',$event_type))?"selected":""; ?> value="mousemove">Mouse Move</option>
      <option <?php echo (is_array($event_type) && count($event_type)>0 && in_array('entervalue',$event_type))?"selected":""; ?> value="entervalue">Enter Value</option>
      <option <?php echo (is_array($event_type) && count($event_type)>0 && in_array('formsubmit',$event_type))?"selected":""; ?> value="formsubmit">Form Submit</option>

    </select></td>

   <td>
    <div class="md-form newFilter">
              <div id="reportrange" class="form-control">
                <span>Choose Date</span> <i class="fa fa-angle-down"></i>
              </div>
              <input name="start_date" id="start-date" class="StartDatepicker" value="<?php echo $start_date!=""?$start_date:""; ?>" type="hidden">
              <input name="end_date" id="end-date" class="EndDatepicker" value="<?php echo $end_date!=""?$end_date:""; ?>" type="hidden">
            </div>
   </td>

    <td><input type="submit" value="Submit"></td>
    <td><input onclick="return window.location.href='<?php echo $baseUrl; ?>rr/new_list.php'" type="reset" value="Reset"></td>

  </tr>

  </form>
</table>


<?php

print("<div class='table-responsive'> 
       <TABLE class=table table-small mb-0>\n");
print("<thead class='thead-dark'><TR>
      <th style='width:40%'>Session</th>
      <th style='width:15%'>Duration</th>
      <TH style='width:30%'>Behaviour</TH>
      <th style='width:15%'>URL</th></TR></thead><tbody>\n");
// loop through the array of files and print them all
if(isset($files) && is_array($files) && count($files)>0){
$i=1;
foreach($files as $fileName=>$strtotime) {
    
        if (substr("$fileName", 0, 1) != "."){ // don't list hidden files
           // if(filesize($dir_path.$fileName)>5000){
                #$fileSize=(filesize($session_dir_path.$fileName)/1024);
             
               // if($dirArray[$index]=="recording_0alu69tas1gb9hs8ron8hm4id1.json"){
                $fileContent=file_get_contents($session_dir_path.$fileName);
                $urlRedirect=str_replace('sessions_','recording_',$fileName);
                 $arra=(json_decode($fileContent,true));
               // print_r($arra);
               // exit;
                $totalSeconds=isset($arra['totalSeconds'])?$arra['totalSeconds']:"";
                $totalMinutes=isset($arra['totalMinutes'])?$arra['totalMinutes']:"";
                $ip_address=isset($arra['ip_address'])?$arra['ip_address']:"";
                $campaign=isset($arra['campaign'])?$arra['campaign']:"";
                $keyword=isset($arra['keyword'])?$arra['keyword']:"";
                $visitUrl=isset($arra['visitUrl'])?$arra['visitUrl']:"";
                
                $ref=isset($arra['ref'])?$arra['ref']:"";
                $nav=isset($arra['nav'])?$arra['nav']:"";
                $os=isset($arra['os'])?$arra['os']:"";

                $gclid=isset($arra['gclid'])?$arra['gclid']:"";
                $network=isset($arra['network'])?$arra['network']:"";
                $visitWidth=isset($arra['visitWidth'])?$arra['visitWidth']:"";
                $visitHeight=isset($arra['visitHeight'])?$arra['visitHeight']:"";
                $startTime=isset($arra['startTime'])?$arra['startTime']:"";
                $totalEvents=isset($arra['totalEvents'])?$arra['totalEvents']:"";
                $endTime=isset($arra['endTime'])?$arra['endTime']:"";
              
                $isActive=isset($arra['isActive'])?$arra['isActive']:"";
                $enterValue=isset($arra['enterValue'])?$arra['enterValue']:"";
                $submitForm=isset($arra['submitForm'])?$arra['submitForm']:"";

                
                $sessionArray=explode('_',$fileName);
                $sessionName=isset($sessionArray[0])?$sessionArray[0]:"";

                $subFile=array_keys($subFiles,$sessionName);
                $totalSessions=(is_array($subFile) && count($subFile)>0)?count($subFile):"0";


               
 
                 
                 // $startTime=isset($arra['events'][0]['timestamp'])?$arra['events'][0]['timestamp']:"";
              
               //  $totalEvents=isset($arra['events'])?count($arra['events']):"";
                //   $endTime=isset($arra['events'][$totalEvents-1]['timestamp'])?$arra['events'][$totalEvents-1]['timestamp']:"";
                  // $diff = abs($endTime - $startTime);
                  // $minutes = round(abs($endTime - $startTime) / 60/60,2)." seconds";
    

                // print_r($arra['events'][0]['timestamp']);
                 //exit;

                 $userId=substr($fileName,0,50);
                 echo "<TR>";   
                
                 echo "<td class='text-bold-500 p-1'>";  
                 echo '<span><i class="fas fa-user"></i>'.$userId.'</span>';
                 echo '<br><span><i class="fas fa-calendar-week"></i>'.date ("F d Y H:i:s.", filemtime($session_dir_path.$fileName)).'</span>';
                 echo '<br> <span><i class="fas fa-map-marker"></i>'.$ip_address.'</span>';
                 echo '<br> <span><i class="fab fa-bandcamp"></i></span>Screen- '.$visitWidth.'X'.$visitHeight.'</span>';
                 echo '<br> <span style=""><i class="fas fa-asterisk"></i></span> Ref. URL- '.substr($ref,0,50).'</span>';
                 echo '<br> <span><i class="fas fa-keyboard"></i></span> OS/Browser -'.$os.'/'.$nav.'</span>';
                 echo '</td>';
                 
                  echo '<td colspan="3">
                          <table class="table border-0">'; 

                            echo '<tr>
                                
                            <td class="p-1 border-0">';
                            echo $totalMinutes>0?$totalMinutes:$totalSeconds; echo $totalMinutes>0?"Mins":"Secs";
                            if($campaign!=""){
                              echo "<br> Camp ID-".$campaign;
                             }

                            echo'</td>
                          
                          <td class="p-1 border-0">';
                          echo $isActive=="yes"?"Mouse-Move":"";
                          echo $enterValue=="yes"?"| Enter-Value":"";
                          echo $submitForm=="yes"?"| Click":"";
                          echo"</td>
                            
                          <td class='p-1 border-0'>
                            <a target='_blank' href='$baseUrl/rr/p.php?rec=".$fileName."'>";
                            echo parse_url($visitUrl, PHP_URL_PATH);
                            echo"</a>
                        </td>
                        
                          </tr>";
                          
                          if($totalSessions>0){ 
                             foreach($subFile as $sub_files){
                            
                            if($sub_files!=""){
                               
                              
                               $sub_fileContent=file_get_contents($session_dir_path.$sub_files);
                
                               $sub_arra=(json_decode($sub_fileContent,true));
                               $Sub_totalSeconds=isset($sub_arra['totalSeconds'])?$sub_arra['totalSeconds']:"";
                               $Sub_totalMinutes=isset($sub_arra['totalMinutes'])?$sub_arra['totalMinutes']:"";
                             
                               $Sub_isActive=isset($sub_arra['isActive'])?$sub_arra['isActive']:"";
                               $Sub_enterValue=isset($sub_arra['enterValue'])?$sub_arra['enterValue']:"";
                               $Sub_submitForm=isset($sub_arra['submitForm'])?$sub_arra['submitForm']:"";
                               $Sub_visitUrl=isset($sub_arra['visitUrl'])?$sub_arra['visitUrl']:"";
              
                              
                              echo '<tr>
                              
                                <td style="width:20%" class="p-1 border-0">';echo $Sub_totalMinutes>0?$Sub_totalMinutes:$Sub_totalSeconds; echo $Sub_totalMinutes>0?"Mins":"Secs";
                                if($campaign!=""){
                                 echo "<br> Camp ID-".$campaign;
                                }
                                echo'</td>
                                
                                <td style="width:60%" class="p-1 border-0">';
                                echo $Sub_isActive=="yes"?"Mouse-Move":"";
                                echo $Sub_enterValue=="yes"?"| Enter-Value":"";
                                echo $Sub_submitForm=="yes"?"| Click":"";
                                echo"</td>
                                  
                                <td style='width:20%' class='p-1 border-0'>
                                  <a target='_blank' href='$baseUrl/rr/p.php?rec=".$sub_files."'>";
                                  echo parse_url($Sub_visitUrl, PHP_URL_PATH);
                                  echo"</a>
                                  
                               </td>
                              
                                </tr>";
                               
                              
                            }
                          }
                          }
                            
                    echo '</table>
                  </td>';
                   



  
              
            // print("<TD>
            // <a target='_blank' href='$baseUrl/rr/p.php?rec=".$urlRedirect."'>$fileName</a><br>");
             
                

            // print("<a target='_blank' href='$baseUrl/sessions/".$fileName."'>Session Data</a>

            // </td>");
            // print("<td style='overflow-wrap: break-word;word-wrap: break-word;word-break: break-all;'>");  echo $keyword; echo '<hr>'; echo $gclid; print("</td>");
            // print("<td>");  echo $ip_address; print("</td>");
            // print("<td>");  print(date ("F d Y H:i:s.", filemtime($session_dir_path.$fileName))); print("</td>");
           
            print("</TR>\n");
           // }
      
        }
        //if($i==300) { exit; }
        if($filter==0 && $i==100){
          break;
        }
    $i++;
}
}
print("</TABLE></div>\n");

?>
<script src="js/vendor.min.js"></script>


<script>
  $(function() {
    <?php if ($start_date != "" && $end_date != "") { ?>
      var start = moment('<?php echo $start_date; ?>');
      var end = moment('<?php echo $end_date; ?>');
    <?php } else { ?>
      //  var start = moment();
      //  var end = moment();
    <?php } ?>

    function cb(start, end) {
      $('#reportrange span').html(start.format('DD, MM, YYYY') + ' - ' + end.format('DD,  MM, YYYY'));
      $('#start-date').val(start.format('Y-MM-DD'));
      $('#end-date').val(end.format('Y-MM-DD'));
    }


    $('#reportrange').daterangepicker( {
      <?php if ($start_date!="" && $end_date!="") { ?> "startDate": "<?php echo date('m/d/Y', strtotime($start_date)); ?>",
        "endDate": "<?php echo date('m/d/Y', strtotime($end_date)); ?>",
      <?php } else { ?> "startDate": moment().subtract(2, 'days'),
        "endDate": moment(),
      <?php } ?>
      format: 'Y-m-d',
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      dateLimit: {
        days: 30
      },
    }, cb);
    cb(start, end);

  });
</script>

<link rel="stylesheet" type="text/css" href="css/pickers/daterange/daterangepicker.css">
<script src="js/pickers/daterange/moment.min.js"></script>
<script src="js/pickers/daterange/daterangepicker.js"></script>