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
    <title>IST 440W - Team 3 Project - Start New Bruteforce OCR Session</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
	<link rel="stylesheet" href="../bin/dropzone.css">
</head>
<body>
	<div class="logo-wrapper"><img src="../bin/logo.png"></img></div>
	<?php buildNav($_SESSION["id"], $_SESSION["username"]); ?>
	<div class="body-wrapper">
		<div class="page-header">
			<h1>Start New Bruteforce OCR Session</h1>
		</div>
		<p>
		To start the Bruteforce OCR process, either drop and drop an image file into the box below or click on the box to browse your computer for the image file to be processed.  The Bruteforce OCR decryption process will then begin automatically.
		</p>
		<p>
		<script src="../bin/jquery-3.5.1.min.js"></script>
		<script src="../bin/dropzone.min.js"></script>
			<center>
				<div id="dropzone">
					<form class="dropzone needsclick" id="ocr-upload" action="upload_file.php">
						<div class="dz-message needsclick">
							<center><img src="../bin/file-upload.png"></img></center>
							<br><b>Drag image file or click here to upload image.</b>
						</div>
					</form>
				</div>
			</center>
		</p>
		<p>
			<a href="../home" class="btn btn-warning">Return Home</a>
		</p>
	</div>

<script>
//Disabling autoDiscover
Dropzone.autoDiscover = false;

$(function() {
    //Dropzone class
    var myDropzone = new Dropzone(".dropzone", {
        url: "upload_file.php",
        paramName: "file",
        maxFilesize: 5,
        maxFiles: 1,
        acceptedFiles: "image/*,application/pdf",
		success: function(file, response){
            window.location = '../process_job/';
    }
    });
});
</script>

</body>
</html>