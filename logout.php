<?php
// initialize the session
session_start();
 
// reset session and variables
$_SESSION = array();
 
// delete session
session_destroy();
 
// go back to login page
header("location: login.php");
exit;
?>