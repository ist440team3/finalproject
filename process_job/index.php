<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../");
    exit;
}

// Include config file
require_once "../config.php";
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IST 440W - Team 3 Project - Bruteforce OCR Job in Progress</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
</head>
<body>
<div class="body-wrapper">
	<div class="page-header">
		<center><h1>Bruteforce OCR In Progress</h1></center>
	</div>
	<div>
		<center><img src="../bin/loading.gif"></img></center>
	</div>
</div>

<form id='process_ocr' action='process_job.php' method='post'>
</form>
<script type='text/javascript'> document.getElementById('process_ocr').submit(); </script>


</body>
</html>