<?php

// Include config file
require_once "../config.php";

// Define DB connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($link === false){
die("ERROR: Could not connect. " . mysqli_connect_error()); }

// Escape POST variable
$reactivateThisUser = $link->real_escape_string($_POST['id']);

// Build and execute SQL statement
$stmt = $link->prepare("UPDATE psu440users SET is_active='1' WHERE id= ?");
$stmt->bind_param("s", $reactivateThisUser);
$stmt->execute();
$stmt->close();

?> 