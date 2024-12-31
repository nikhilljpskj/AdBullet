<?php 
$baseUrl="https://".$_SERVER['HTTP_HOST']."/";

$mysqli = new mysqli("localhost", "brandscoot", "Brandscoot@654321", "recordings");

//var_dump($location);  

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

?>
<style class="INLINE_PEN_STYLESHEET_ID">
    
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rrweb-player@latest/dist/style.css">
  
  
<div id="wrapper"></div>
  
<script src="<?php echo $baseUrl; ?>rr/js/jquery-2.1.4.min.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/rrweb-player@latest/dist/index.js"></script>
<script>
<?php $rec=isset($_GET['rec'])?$_GET['rec']:"7bijvprujk6s311qvjc7sjn671_aHR0cHM6Ly93d3cuY29tcGFyZWR0aC5jb20vcmVzdC1vZi1pbmRpYS81NS90YXRhLXNreS1oZC1ib3gtbmV3LWNvbm5lY3Rpb24uaHRtbA==.json"; ?>
 var baseUrl='<?php echo $baseUrl; ?>rr/recordings/<?php echo urlencode($rec); ?>';
 console.log('baseUrl',baseUrl);
 async function makeHeadRequest() {
 var dd="";
 let res = await axios.get(baseUrl).then((response) => {
  dd=(response.data);
  events=(dd.events);
  //console.log('events',typeof(events));     
  //console.log('result',typeof(yy));  
  new rrwebPlayer({
    target: document.getElementById("wrapper"),
    data: {
      events,
      tags: {
      'btn-Click': 'red',
      'inputValues': '#21e676',
     },
      autoPlay: true } 
    });
  }).catch((err) => { });
}
makeHeadRequest();
</script>