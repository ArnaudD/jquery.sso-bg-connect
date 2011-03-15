<?php

session_start();
session_unset();
session_destroy();
$_SESSION = array ();
foreach($_COOKIE as $key => $value)
    unset($_COOKIE[$key]);

header ('location: index.php');

?>
