<?php 
// Initialize the session
session_start();

if(!empty($_FILES)){

     
    // FILE PATH CONFIG
    $uploadDir = "../upload/originals/"; 
    $uploadfileName = basename($_FILES['file']['name']); 
    $uploadFilePath = $uploadDir.$uploadfileName; 
     
	$_SESSION["uploadedFilename"] = $uploadfileName; 
	
    // UPLOAD FILE TO SERVER 
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)){

		}
}
?>