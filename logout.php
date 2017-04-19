<?php 
include "includes/base.php"; 
$_SESSION = array(); 
session_destroy(); 
session_start();
$_SESSION['success'] = "Logout Successful.";
?>
<meta http-equiv="refresh" content="0;index.php">
