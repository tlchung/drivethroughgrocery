<?php
// database information
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login_grocery_db');
 
// database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// making sure database gets connected
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>