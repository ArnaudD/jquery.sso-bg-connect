<?php

session_start ();
require_once 'facebook-sdk/facebook.php';
require_once 'conf.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook($conf['facebook']);

$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $me = $facebook->api('/me');
    $_SESSION['user'] = array ('name' => $me['name'], 'sso' => 'facebook');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

if (array_key_exists ('bgConnect', $_REQUEST)){
  if ($me) {
     echo '<script type="text/javascript">'
         .'parent.jQuery.ssoBgConnect (\'finishAuthentication\', '.json_encode ($_SESSION['user']).');'
         .'</script>';
  }
}


