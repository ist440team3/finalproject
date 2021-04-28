<?php

// Include config file
require_once "../config.php";

// Define DB connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error()); }

// Escape POST variable
$deactivateThisUser = $link->real_escape_string($_POST['id']);

// If this user is ID #3, then exit and do not proceed
if ($deactivateThisUser=='3'){exit;}

// Build and execute SQL statement
$stmt = $link->prepare("UPDATE psu440users SET is_active='2' WHERE id= ?");
$stmt->bind_param("s", $deactivateThisUser);
$stmt->execute();
$stmt->close();

?> 