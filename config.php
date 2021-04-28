<?php
/* Database config file */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'psuproject');
define('DB_PASSWORD', 'p3nNNst@t3pr0J3KTist440w');
define('DB_NAME', 'ist440');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}



// Build Navigation Menu Function
function buildNav($current_userid, $current_username) {
  
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error()); }
  
  $sql = "SELECT type FROM psu440users WHERE id = '$current_userid' AND username = '$current_username'";
  $result = $link->query($sql);
  $usercheck = $result->fetch_assoc();
  $userlevel = $usercheck["type"];
  
  if ($userlevel==1){
	echo "<div class='menu-wrapper1'>";
	echo "<script type='text/javascript' src='../bin/PSU440WAdminMenu.js?h=898C'></script>";
	echo "<div id='PSU440WAdminMenu'></div>";
	echo "</div>";
	}
  elseif ($userlevel==2){
	echo "<div class='menu-wrapper2'>";
	echo "<script type='text/javascript' src='../bin/PSU440WMenu.js?h=15'></script>";
	echo "<div id='PSU440WMenu'></div>";
	echo "</div>";
	}
  else { echo "<p>USER LEVEL COULD NOT BE DETERMINED</p>"; }
}



// Check if User Has Admin Privledges to View Page
function checkPrivledge($current_userid, $current_username) {

  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error()); }
  
  $sql = "SELECT type FROM psu440users WHERE id = '$current_userid' AND username = '$current_username'";
  $result = $link->query($sql);
  $usercheck = $result->fetch_assoc();
  $userlevel = $usercheck["type"];
  
  if ($userlevel!=1){
	header("location: ../home");
    exit;
	}
}


?>
