<?php

if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

session_start();

$dbhost = ""; // this will ususally be 'localhost', but can sometimes differ
$dbname = ""; // the name of the database that you are going to use for this project
$dbuser = ""; // the username that you created, or were given, to access your database
$dbpass = ""; // the password that you created, or were given, to access your database

$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die("Connection Error " . mysqli_error($link));

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="allscripts.js"></script>
