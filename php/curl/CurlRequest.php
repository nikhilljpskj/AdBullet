<?php
class CurlRequest
{
   function exec($method, $url, $obj = array()) {
     
    $curl = curl_init();
     
    switch($method) {
      case 'GET':
        if(strrpos($url, "?") === FALSE) {
          $url .= '?' . http_build_query($obj);
        }
         curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($obj)); // body
        break;
      case 'POST': 
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
        break;
      case 'PUT':
      case 'DELETE':
      default:
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method)); // method
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body
    }
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
     'Accept: application/json',
     'Content-Type: application/json',
     "authorization: Token 4dfff06ff84f49e91fdeaf01502a63d932054279"
     )); 
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
    
    // Exec
    $response = curl_exec($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);
    
    // Data
    $header = trim(substr($response, 0, $info['header_size']));
    $body = substr($response, $info['header_size']);
     
    return array('status' => $info['http_code'], 'header' => $header, 'data' => json_decode($body));
  }
  function get($url, $obj = array()) {
     return $this->exec("GET", $url, $obj);
  }
  function post($url, $obj = array()) {
     return $this->exec("POST", $url, $obj);
  }
  function put($url, $obj = array()) {
     return $this->exec("PUT", $url, $obj);
  }
  function delete($url, $obj = array()) {
     return $this->exec("DELETE", $url, $obj);
  }
}?>