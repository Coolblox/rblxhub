<?php
$sitename = "RBLXHub";
$title = "RBLXHub: A FREE Virtual World-Building Game with Avatar Chat, 3D Environments, and Physics";
if( !function_exists('apache_request_headers') ) {

function apache_request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do some nasty string manipulations to restore the original letter case
      // this should work in most cases
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
  }
}

$host = "localhost";
$username = "id16177648_rblxhub_user";
$password = "1O]a/~rn+GE}26TB";

$connect = mysqli_connect($host, $username, $password) or die("Failed to connect to SQL DB: ". mysqli_connect_error());
mysqli_select_db($connect, "id16177648_rblxhubdatabase") or die(mysqli_error($connect));

$usrip = $_SERVER['REMOTE_ADDR'];
$usriphash = md5($usrip);

$ipbq = mysqli_query($connect, "SELECT * FROM ip_bans WHERE ip='$usrip' OR ip='$usriphash'") or die(mysqli_error($connect));
if (mysqli_num_rows($ipbq) > 0) {
  header("Location: /ipban");
  die("Access denied.");
}

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}





?>
