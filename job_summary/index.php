<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../");
    exit;
}

//INCLUDE CONFIG FILE
require_once "../config.php";

//SET JOB ID TO BE USED FOR JOB SUMMARY PAGE
$jobid = $_POST['jobToDisplay'];

//QUERY DB TO OBTAIN MAIN JOB VARIABLES
	$jobDetailsSql  = "SELECT usr_id, usr_img_id, ocr_id, brute_id, log_id, translate_id, job_time_started, job_time_ended ";
	$jobDetailsSql .= "FROM job WHERE job_id = $jobid";
	$jobDetailsQuery = mysqli_query($link, $jobDetailsSql);
	if ($jobDetailsQuery->num_rows > 0) {
		while($jobDetails = mysqli_fetch_assoc($jobDetailsQuery)) {
			$usr_id = $jobDetails["usr_id"];
			$usr_img_id = $jobDetails["usr_img_id"];
			$ocr_id = $jobDetails["ocr_id"];
			$brute_id = $jobDetails["brute_id"];
			$log_id = $jobDetails["log_id"];
			$translate_id = $jobDetails["translate_id"];
			$job_time_started = $jobDetails["job_time_started"];
			$job_time_ended = $jobDetails["job_time_ended"];
			$jobSqlQuerySuccess = true;
		}
	} else { $jobSqlQuerySuccess = false; }

//QUERY DB TO OBTAIN IMAGE DETAILS
	$imageDetailsSql  = "SELECT usr_img_orig_fname, usr_img_orig_fformat, usr_img_orig_fsize, usr_img_orig_height, ";
	$imageDetailsSql .= "usr_img_orig_width, usr_img_opt_fname, usr_img_opt_fformat, usr_img_opt_fsize, usr_img_opt_height, ";
	$imageDetailsSql .= "usr_img_opt_width FROM user_image WHERE usr_img_id = $usr_img_id";
	$imageDetailsQuery = mysqli_query($link, $imageDetailsSql);
	if ($imageDetailsQuery->num_rows > 0) {
		while($imageDetails = mysqli_fetch_assoc($imageDetailsQuery)) {
			$usr_img_orig_fname = $imageDetails["usr_img_orig_fname"];
			$usr_img_orig_fformat = $imageDetails["usr_img_orig_fformat"];
			$usr_img_orig_fsize = $imageDetails["usr_img_orig_fsize"];
			$usr_img_orig_height = $imageDetails["usr_img_orig_height"];
			$usr_img_orig_width = $imageDetails["usr_img_orig_width"];
			$usr_img_opt_fname = $imageDetails["usr_img_opt_fname"];
			$usr_img_opt_fformat = $imageDetails["usr_img_opt_fformat"];
			$usr_img_opt_fsize = $imageDetails["usr_img_opt_fsize"];
			$usr_img_opt_height = $imageDetails["usr_img_opt_height"];
			$usr_img_opt_width = $imageDetails["usr_img_opt_width"];
		}
	} else { $jobSqlQuerySuccess = false; }

//QUERY DB TO OBTAIN OCR TEXT OUTPUT
	$ocrDetailsSql  = "SELECT ocr_txt_output FROM ocr WHERE ocr_id = $ocr_id";
	$ocrDetailsQuery = mysqli_query($link, $ocrDetailsSql);
	if ($ocrDetailsQuery->num_rows > 0) {
		while($ocrDetails = mysqli_fetch_assoc($ocrDetailsQuery)) {
			$ocr_txt_output = $ocrDetails["ocr_txt_output"];
		}
	} else { $jobSqlQuerySuccess = false; }

//QUERY DB TO OBTAIN BRUTEFORCE OUTPUTS
	$bruteDetailsSql  = "SELECT atbash, bacon, c01, c02, c03, c04, c05, c06, c07, c08, c09, c10, c11, c12, c13, ";
	$bruteDetailsSql .= "c14, c15, c16, c17, c18, c19, c20, c21, c22, c23, c24, c25 FROM bruteforce WHERE brute_id = $brute_id";
	$bruteDetailsQuery = mysqli_query($link, $bruteDetailsSql);
	if ($bruteDetailsQuery->num_rows > 0) {
		while($bruteDetails = mysqli_fetch_assoc($bruteDetailsQuery)) {
			$brute_atbash = $bruteDetails["atbash"];
			$brute_bacon = $bruteDetails["bacon"];
			$brute_caesar01 = $bruteDetails["c01"];
			$brute_caesar02 = $bruteDetails["c02"];
			$brute_caesar03 = $bruteDetails["c03"];
			$brute_caesar04 = $bruteDetails["c04"];
			$brute_caesar05 = $bruteDetails["c05"];
			$brute_caesar06 = $bruteDetails["c06"];
			$brute_caesar07 = $bruteDetails["c07"];
			$brute_caesar08 = $bruteDetails["c08"];
			$brute_caesar09 = $bruteDetails["c09"];
			$brute_caesar10 = $bruteDetails["c10"];
			$brute_caesar11 = $bruteDetails["c11"];
			$brute_caesar12 = $bruteDetails["c12"];
			$brute_caesar13 = $bruteDetails["c13"];
			$brute_caesar14 = $bruteDetails["c14"];
			$brute_caesar15 = $bruteDetails["c15"];
			$brute_caesar16 = $bruteDetails["c16"];
			$brute_caesar17 = $bruteDetails["c17"];
			$brute_caesar18 = $bruteDetails["c18"];
			$brute_caesar19 = $bruteDetails["c19"];
			$brute_caesar20 = $bruteDetails["c20"];
			$brute_caesar21 = $bruteDetails["c21"];
			$brute_caesar22 = $bruteDetails["c22"];
			$brute_caesar23 = $bruteDetails["c23"];
			$brute_caesar24 = $bruteDetails["c24"];
			$brute_caesar25 = $bruteDetails["c25"];
		}
	} else { $jobSqlQuerySuccess = false; }
	
//QUERY DB FOR TRANSLATION RECORD IDS      
	$languageIdSql = "SELECT lang_german_id, lang_english_id, lang_spanish_id, lang_french_id FROM lang_translate WHERE translate_id = {$translate_id}";
	$languageIdQuery = mysqli_query($link, $languageIdSql);
	if ($languageIdQuery->num_rows > 0) {
		while($languageIds = mysqli_fetch_assoc($languageIdQuery)) {
			$german_id = $languageIds["lang_german_id"];
			$english_id = $languageIds["lang_english_id"];
			$spanish_id = $languageIds["lang_spanish_id"];
			$french_id = $languageIds["lang_french_id"];
		}
	} else { $jobSqlQuerySuccess = false; }

//QUERY DB TO OBTAIN ENGLISH TRANSLATIONS
	$englishDetailsSql  = "SELECT en_orig, en_atbash, en_bacon, en_c01, en_c02, en_c03, en_c04, en_c05, en_c06, en_c07, en_c08, en_c09, en_c10, en_c11, en_c12, en_c13, ";
	$englishDetailsSql .= "en_c14, en_c15, en_c16, en_c17, en_c18, en_c19, en_c20, en_c21, en_c22, en_c23, en_c24, en_c25 FROM lang_english WHERE lang_english_id = $english_id";
	$englishDetailsQuery = mysqli_query($link, $englishDetailsSql);
	if ($englishDetailsQuery->num_rows > 0) {
		while($englishDetails = mysqli_fetch_assoc($englishDetailsQuery)) {
			$english_orig = $englishDetails["en_orig"];
			$english_atbash = $englishDetails["en_atbash"];
			$english_bacon = $englishDetails["en_bacon"];
			$english_caesar01 = $englishDetails["en_c01"];
			$english_caesar02 = $englishDetails["en_c02"];
			$english_caesar03 = $englishDetails["en_c03"];
			$english_caesar04 = $englishDetails["en_c04"];
			$english_caesar05 = $englishDetails["en_c05"];
			$english_caesar06 = $englishDetails["en_c06"];
			$english_caesar07 = $englishDetails["en_c07"];
			$english_caesar08 = $englishDetails["en_c08"];
			$english_caesar09 = $englishDetails["en_c09"];
			$english_caesar10 = $englishDetails["en_c10"];
			$english_caesar11 = $englishDetails["en_c11"];
			$english_caesar12 = $englishDetails["en_c12"];
			$english_caesar13 = $englishDetails["en_c13"];
			$english_caesar14 = $englishDetails["en_c14"];
			$english_caesar15 = $englishDetails["en_c15"];
			$english_caesar16 = $englishDetails["en_c16"];
			$english_caesar17 = $englishDetails["en_c17"];
			$english_caesar18 = $englishDetails["en_c18"];
			$english_caesar19 = $englishDetails["en_c19"];
			$english_caesar20 = $englishDetails["en_c20"];
			$english_caesar21 = $englishDetails["en_c21"];
			$english_caesar22 = $englishDetails["en_c22"];
			$english_caesar23 = $englishDetails["en_c23"];
			$english_caesar24 = $englishDetails["en_c24"];
			$english_caesar25 = $englishDetails["en_c25"];
		}
	} else { $jobSqlQuerySuccess = false; }
	
//QUERY DB TO OBTAIN FRENCH TRANSLATIONS
	$frenchDetailsSql  = "SELECT fr_orig, fr_atbash, fr_bacon, fr_c01, fr_c02, fr_c03, fr_c04, fr_c05, fr_c06, fr_c07, fr_c08, fr_c09, fr_c10, fr_c11, fr_c12, fr_c13, ";
	$frenchDetailsSql .= "fr_c14, fr_c15, fr_c16, fr_c17, fr_c18, fr_c19, fr_c20, fr_c21, fr_c22, fr_c23, fr_c24, fr_c25 FROM lang_french WHERE lang_french_id = $french_id";
	$frenchDetailsQuery = mysqli_query($link, $frenchDetailsSql);
	if ($frenchDetailsQuery->num_rows > 0) {
		while($frenchDetails = mysqli_fetch_assoc($frenchDetailsQuery)) {
			$french_orig = $frenchDetails["fr_orig"];
			$french_atbash = $frenchDetails["fr_atbash"];
			$french_bacon = $frenchDetails["fr_bacon"];
			$french_caesar01 = $frenchDetails["fr_c01"];
			$french_caesar02 = $frenchDetails["fr_c02"];
			$french_caesar03 = $frenchDetails["fr_c03"];
			$french_caesar04 = $frenchDetails["fr_c04"];
			$french_caesar05 = $frenchDetails["fr_c05"];
			$french_caesar06 = $frenchDetails["fr_c06"];
			$french_caesar07 = $frenchDetails["fr_c07"];
			$french_caesar08 = $frenchDetails["fr_c08"];
			$french_caesar09 = $frenchDetails["fr_c09"];
			$french_caesar10 = $frenchDetails["fr_c10"];
			$french_caesar11 = $frenchDetails["fr_c11"];
			$french_caesar12 = $frenchDetails["fr_c12"];
			$french_caesar13 = $frenchDetails["fr_c13"];
			$french_caesar14 = $frenchDetails["fr_c14"];
			$french_caesar15 = $frenchDetails["fr_c15"];
			$french_caesar16 = $frenchDetails["fr_c16"];
			$french_caesar17 = $frenchDetails["fr_c17"];
			$french_caesar18 = $frenchDetails["fr_c18"];
			$french_caesar19 = $frenchDetails["fr_c19"];
			$french_caesar20 = $frenchDetails["fr_c20"];
			$french_caesar21 = $frenchDetails["fr_c21"];
			$french_caesar22 = $frenchDetails["fr_c22"];
			$french_caesar23 = $frenchDetails["fr_c23"];
			$french_caesar24 = $frenchDetails["fr_c24"];
			$french_caesar25 = $frenchDetails["fr_c25"];
		}
	} else { $jobSqlQuerySuccess = false; }

//QUERY DB TO OBTAIN GERMAN TRANSLATIONS
	$germanDetailsSql  = "SELECT de_orig, de_atbash, de_bacon, de_c01, de_c02, de_c03, de_c04, de_c05, de_c06, de_c07, de_c08, de_c09, de_c10, de_c11, de_c12, de_c13, ";
	$germanDetailsSql .= "de_c14, de_c15, de_c16, de_c17, de_c18, de_c19, de_c20, de_c21, de_c22, de_c23, de_c24, de_c25 FROM lang_german WHERE lang_german_id = $german_id";
	$germanDetailsQuery = mysqli_query($link, $germanDetailsSql);
	if ($germanDetailsQuery->num_rows > 0) {
		while($germanDetails = mysqli_fetch_assoc($germanDetailsQuery)) {
			$german_orig = $germanDetails["de_orig"];
			$german_atbash = $germanDetails["de_atbash"];
			$german_bacon = $germanDetails["de_bacon"];
			$german_caesar01 = $germanDetails["de_c01"];
			$german_caesar02 = $germanDetails["de_c02"];
			$german_caesar03 = $germanDetails["de_c03"];
			$german_caesar04 = $germanDetails["de_c04"];
			$german_caesar05 = $germanDetails["de_c05"];
			$german_caesar06 = $germanDetails["de_c06"];
			$german_caesar07 = $germanDetails["de_c07"];
			$german_caesar08 = $germanDetails["de_c08"];
			$german_caesar09 = $germanDetails["de_c09"];
			$german_caesar10 = $germanDetails["de_c10"];
			$german_caesar11 = $germanDetails["de_c11"];
			$german_caesar12 = $germanDetails["de_c12"];
			$german_caesar13 = $germanDetails["de_c13"];
			$german_caesar14 = $germanDetails["de_c14"];
			$german_caesar15 = $germanDetails["de_c15"];
			$german_caesar16 = $germanDetails["de_c16"];
			$german_caesar17 = $germanDetails["de_c17"];
			$german_caesar18 = $germanDetails["de_c18"];
			$german_caesar19 = $germanDetails["de_c19"];
			$german_caesar20 = $germanDetails["de_c20"];
			$german_caesar21 = $germanDetails["de_c21"];
			$german_caesar22 = $germanDetails["de_c22"];
			$german_caesar23 = $germanDetails["de_c23"];
			$german_caesar24 = $germanDetails["de_c24"];
			$german_caesar25 = $germanDetails["de_c25"];
		}
	} else { $jobSqlQuerySuccess = false; }
	
//QUERY DB TO OBTAIN SPANISH TRANSLATIONS
	$spanishDetailsSql  = "SELECT es_orig, es_atbash, es_bacon, es_c01, es_c02, es_c03, es_c04, es_c05, es_c06, es_c07, es_c08, es_c09, es_c10, es_c11, es_c12, es_c13, ";
	$spanishDetailsSql .= "es_c14, es_c15, es_c16, es_c17, es_c18, es_c19, es_c20, es_c21, es_c22, es_c23, es_c24, es_c25 FROM lang_spanish WHERE lang_spanish_id = $spanish_id";
	$spanishDetailsQuery = mysqli_query($link, $spanishDetailsSql);
	if ($spanishDetailsQuery->num_rows > 0) {
		while($spanishDetails = mysqli_fetch_assoc($spanishDetailsQuery)) {
			$spanish_orig = $spanishDetails["es_orig"];
			$spanish_atbash = $spanishDetails["es_atbash"];
			$spanish_bacon = $spanishDetails["es_bacon"];
			$spanish_caesar01 = $spanishDetails["es_c01"];
			$spanish_caesar02 = $spanishDetails["es_c02"];
			$spanish_caesar03 = $spanishDetails["es_c03"];
			$spanish_caesar04 = $spanishDetails["es_c04"];
			$spanish_caesar05 = $spanishDetails["es_c05"];
			$spanish_caesar06 = $spanishDetails["es_c06"];
			$spanish_caesar07 = $spanishDetails["es_c07"];
			$spanish_caesar08 = $spanishDetails["es_c08"];
			$spanish_caesar09 = $spanishDetails["es_c09"];
			$spanish_caesar10 = $spanishDetails["es_c10"];
			$spanish_caesar11 = $spanishDetails["es_c11"];
			$spanish_caesar12 = $spanishDetails["es_c12"];
			$spanish_caesar13 = $spanishDetails["es_c13"];
			$spanish_caesar14 = $spanishDetails["es_c14"];
			$spanish_caesar15 = $spanishDetails["es_c15"];
			$spanish_caesar16 = $spanishDetails["es_c16"];
			$spanish_caesar17 = $spanishDetails["es_c17"];
			$spanish_caesar18 = $spanishDetails["es_c18"];
			$spanish_caesar19 = $spanishDetails["es_c19"];
			$spanish_caesar20 = $spanishDetails["es_c20"];
			$spanish_caesar21 = $spanishDetails["es_c21"];
			$spanish_caesar22 = $spanishDetails["es_c22"];
			$spanish_caesar23 = $spanishDetails["es_c23"];
			$spanish_caesar24 = $spanishDetails["es_c24"];
			$spanish_caesar25 = $spanishDetails["es_c25"];
		}
	} else { $jobSqlQuerySuccess = false; }
	
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IST 440W - Team 3 Project - Job Summary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="../bin/css.css">
</head>
<body>
<div class="logo-wrapper"><img src="../bin/logo.png"></img></div>
<?php buildNav($_SESSION["id"], $_SESSION["username"]); ?>
<div class="body-wrapper">
	<div class="page-header">
		<center><h1>Job Summary</h1></center>
	</div>
	<div>
		<p>
		<?php
		if ($jobSqlQuerySuccess){
			echo "<table border='0'><tr><td width='760px'>";
			echo "<p><b>Job ID: </b>". $jobid ."<br>";
			echo "<b>User ID of Who Performed Job: </b>". $usr_id ."<br>";
			echo "<b>Image Table ID: </b>". $usr_img_id ."<br>";
			echo "<b>OCR Table ID: </b>". $ocr_id ."<br>";
			echo "<b>Brute Table ID: </b>". $brute_id ."<br>";
			echo "<b>Log Table ID: </b>". $log_id ."<br>";
			echo "<b>Translate Table ID: </b>". $translate_id ."<br>";
			echo "<b>Timestamp of When Job Started: </b>". $job_time_started ."<br>";
			echo "<b>Timestamp of When Job Ended: </b>". $job_time_ended ."</p>";
			echo "</td><td width='335px'>";
			echo "<center><a href='../upload/originals/{$usr_img_orig_fname}' target='_blank'><img src='../upload/originals/{$usr_img_orig_fname}' class='job-summary-original-image'></img></a>";
			echo "<br><b><i>Original Uploaded Image</i></b></center>";
			echo "</td></tr><tr><td width='50%'>";
			echo "<p><b>Original Image Filename: </b>". $usr_img_orig_fname ."<br>";
			echo "<b>Original Image File Type: </b>". $usr_img_orig_fformat ."<br>";
			echo "<b>Original Image File Size: </b>". $usr_img_orig_fsize ."<br>";
			echo "<b>Original Image Pixel Height: </b>". $usr_img_orig_height ."<br>";
			echo "<b>Original Image Pixel Width: </b>". $usr_img_orig_width ."<br>";
			echo "<b>Optimized Image Filename: </b>". $usr_img_opt_fname ."<br>";
			echo "<b>Optimized Image File Type: </b>". $usr_img_opt_fformat ."<br>";
			echo "<b>Optimized Image File Size: </b>". $usr_img_opt_fsize ."<br>";
			echo "<b>Optimized Image Pixel Height: </b>". $usr_img_opt_height ."<br>";
			echo "<b>Optimized Image Pixel Width: </b>". $usr_img_opt_width ."</p>";
			echo "</td><td width='335px'>";
			
			echo "</td></tr><tr><td width='760px'>";
			
			echo "<p><b>OCR Text Output: </b>". $ocr_txt_output ."</p>";
			
			echo "<p><b>English Translation Table ID: </b>". $english_id ."<br>";
			echo "<b>German Translation Table ID: </b>". $german_id ."<br>";
			echo "<b>French Translation Table ID: </b>". $french_id ."<br>";
			echo "<b>Spanish Translation Table ID: </b>". $spanish_id ."</p>";
			
			echo "<p><b>Original English Output: </b>". $english_orig ."<br>";
			echo "<b>Original French Output: </b>". $french_orig ."<br>";
			echo "<b>Original German Output: </b>". $german_orig ."<br>";
			echo "<b>Original Spanish Output: </b>". $spanish_orig ."</p>";
			echo "</td><td width='335px'></td></tr></table>";
			
			echo "</div></div>";
		?>
		
	<div class="body-wrapper">
		<div class="page-header">
			<center><h3>atBash Outputs</h3></center>
		</div>
	<div>
		<?php
			echo "<p><b>atBash Original Text Output: </b>". $brute_atbash ."<br>";
			echo "<b>atBash English Output: </b>". $english_atbash ."<br>";
			echo "<b>atBash French Output: </b>". $french_atbash ."<br>";
			echo "<b>atBash German Output: </b>". $german_atbash ."<br>";
			echo "<b>atBash Spanish Output: </b>". $spanish_atbash ."</p>";
			echo "</div></div>";
		?>
		
	<div class="body-wrapper">
		<div class="page-header">
			<center><h3>Baconian Outputs</h3></center>
		</div>
	<div>
	
		<?php	
			echo "<p><b>Bacon Original Text Output: </b>". $brute_bacon ."<br>";
			echo "<b>Bacon English Output: </b>". $english_bacon ."<br>";
			echo "<b>Bacon French Output: </b>". $french_bacon ."<br>";
			echo "<b>Bacon German Output: </b>". $german_bacon ."<br>";
			echo "<b>Bacon Spanish Output: </b>". $spanish_bacon ."<br>";
			echo "</div></div>";
		?>
		
	<div class="body-wrapper">
		<div class="page-header">
			<center><h3>Caesar Outputs</h3></center>
		</div>
	<div>
		<?php	
			echo "<p><b>Caesar 01 Key Shift - Original Text Output: </b>". $brute_caesar01 ."<br>";
			echo "<b>Caesar 02 Key Shift - Original Text Output: </b>". $brute_caesar02 ."<br>";
			echo "<b>Caesar 03 Key Shift - Original Text Output: </b>". $brute_caesar03 ."<br>";
			echo "<b>Caesar 04 Key Shift - Original Text Output: </b>". $brute_caesar04 ."<br>";
			echo "<b>Caesar 05 Key Shift - Original Text Output: </b>". $brute_caesar05 ."<br>";
			echo "<b>Caesar 06 Key Shift - Original Text Output: </b>". $brute_caesar06 ."<br>";
			echo "<b>Caesar 07 Key Shift - Original Text Output: </b>". $brute_caesar07 ."<br>";
			echo "<b>Caesar 08 Key Shift - Original Text Output: </b>". $brute_caesar08 ."<br>";
			echo "<b>Caesar 09 Key Shift - Original Text Output: </b>". $brute_caesar09 ."<br>";
			echo "<b>Caesar 10 Key Shift - Original Text Output: </b>". $brute_caesar10 ."<br>";
			echo "<b>Caesar 11 Key Shift - Original Text Output: </b>". $brute_caesar11 ."<br>";
			echo "<b>Caesar 12 Key Shift - Original Text Output: </b>". $brute_caesar12 ."<br>";
			echo "<b>Caesar 13 Key Shift - Original Text Output: </b>". $brute_caesar13 ."<br>";
			echo "<b>Caesar 14 Key Shift - Original Text Output: </b>". $brute_caesar14 ."<br>";
			echo "<b>Caesar 15 Key Shift - Original Text Output: </b>". $brute_caesar15 ."<br>";
			echo "<b>Caesar 16 Key Shift - Original Text Output: </b>". $brute_caesar16 ."<br>";
			echo "<b>Caesar 17 Key Shift - Original Text Output: </b>". $brute_caesar17 ."<br>";
			echo "<b>Caesar 18 Key Shift - Original Text Output: </b>". $brute_caesar18 ."<br>";
			echo "<b>Caesar 19 Key Shift - Original Text Output: </b>". $brute_caesar19 ."<br>";
			echo "<b>Caesar 20 Key Shift - Original Text Output: </b>". $brute_caesar20 ."<br>";
			echo "<b>Caesar 21 Key Shift - Original Text Output: </b>". $brute_caesar21 ."<br>";
			echo "<b>Caesar 22 Key Shift - Original Text Output: </b>". $brute_caesar22 ."<br>";
			echo "<b>Caesar 23 Key Shift - Original Text Output: </b>". $brute_caesar23 ."<br>";
			echo "<b>Caesar 24 Key Shift - Original Text Output: </b>". $brute_caesar24 ."<br>";
			echo "<b>Caesar 25 Key Shift - Original Text Output: </b>". $brute_caesar25 ."</p>";

			echo "<p><b>Caesar 01 English Output: </b>". $english_caesar01 ."<br>";
			echo "<b>Caesar 02 English Output: </b>". $english_caesar02 ."<br>";
			echo "<b>Caesar 03 English Output: </b>". $english_caesar03 ."<br>";
			echo "<b>Caesar 04 English Output: </b>". $english_caesar04 ."<br>";
			echo "<b>Caesar 05 English Output: </b>". $english_caesar05 ."<br>";
			echo "<b>Caesar 06 English Output: </b>". $english_caesar06 ."<br>";
			echo "<b>Caesar 07 English Output: </b>". $english_caesar07 ."<br>";
			echo "<b>Caesar 08 English Output: </b>". $english_caesar08 ."<br>";
			echo "<b>Caesar 09 English Output: </b>". $english_caesar09 ."<br>";
			echo "<b>Caesar 10 English Output: </b>". $english_caesar10 ."<br>";
			echo "<b>Caesar 11 English Output: </b>". $english_caesar11 ."<br>";
			echo "<b>Caesar 12 English Output: </b>". $english_caesar12 ."<br>";
			echo "<b>Caesar 13 English Output: </b>". $english_caesar13 ."<br>";
			echo "<b>Caesar 14 English Output: </b>". $english_caesar14 ."<br>";
			echo "<b>Caesar 15 English Output: </b>". $english_caesar15 ."<br>";
			echo "<b>Caesar 16 English Output: </b>". $english_caesar16 ."<br>";
			echo "<b>Caesar 17 English Output: </b>". $english_caesar17 ."<br>";
			echo "<b>Caesar 18 English Output: </b>". $english_caesar18 ."<br>";
			echo "<b>Caesar 19 English Output: </b>". $english_caesar19 ."<br>";
			echo "<b>Caesar 20 English Output: </b>". $english_caesar20 ."<br>";
			echo "<b>Caesar 21 English Output: </b>". $english_caesar21 ."<br>";
			echo "<b>Caesar 22 English Output: </b>". $english_caesar22 ."<br>";
			echo "<b>Caesar 23 English Output: </b>". $english_caesar23 ."<br>";
			echo "<b>Caesar 24 English Output: </b>". $english_caesar24 ."<br>";
			echo "<b>Caesar 25 English Output: </b>". $english_caesar25 ."</p>";

			echo "<p><b>Caesar 01 French Output: </b>". $french_caesar01 ."<br>";
			echo "<b>Caesar 02 French Output: </b>". $french_caesar02 ."<br>";
			echo "<b>Caesar 03 French Output: </b>". $french_caesar03 ."<br>";
			echo "<b>Caesar 04 French Output: </b>". $french_caesar04 ."<br>";
			echo "<b>Caesar 05 French Output: </b>". $french_caesar05 ."<br>";
			echo "<b>Caesar 06 French Output: </b>". $french_caesar06 ."<br>";
			echo "<b>Caesar 07 French Output: </b>". $french_caesar07 ."<br>";
			echo "<b>Caesar 08 French Output: </b>". $french_caesar08 ."<br>";
			echo "<b>Caesar 09 French Output: </b>". $french_caesar09 ."<br>";
			echo "<b>Caesar 10 French Output: </b>". $french_caesar10 ."<br>";
			echo "<b>Caesar 11 French Output: </b>". $french_caesar11 ."<br>";
			echo "<b>Caesar 12 French Output: </b>". $french_caesar12 ."<br>";
			echo "<b>Caesar 13 French Output: </b>". $french_caesar13 ."<br>";
			echo "<b>Caesar 14 French Output: </b>". $french_caesar14 ."<br>";
			echo "<b>Caesar 15 French Output: </b>". $french_caesar15 ."<br>";
			echo "<b>Caesar 16 French Output: </b>". $french_caesar16 ."<br>";
			echo "<b>Caesar 17 French Output: </b>". $french_caesar17 ."<br>";
			echo "<b>Caesar 18 French Output: </b>". $french_caesar18 ."<br>";
			echo "<b>Caesar 19 French Output: </b>". $french_caesar19 ."<br>";
			echo "<b>Caesar 20 French Output: </b>". $french_caesar20 ."<br>";
			echo "<b>Caesar 21 French Output: </b>". $french_caesar21 ."<br>";
			echo "<b>Caesar 22 French Output: </b>". $french_caesar22 ."<br>";
			echo "<b>Caesar 23 French Output: </b>". $french_caesar23 ."<br>";
			echo "<b>Caesar 24 French Output: </b>". $french_caesar24 ."<br>";
			echo "<b>Caesar 25 French Output: </b>". $french_caesar25 ."</p>";

			echo "<p><b>Caesar 01 German Output: </b>". $german_caesar01 ."<br>";
			echo "<b>Caesar 02 German Output: </b>". $german_caesar02 ."<br>";
			echo "<b>Caesar 03 German Output: </b>". $german_caesar03 ."<br>";
			echo "<b>Caesar 04 German Output: </b>". $german_caesar04 ."<br>";
			echo "<b>Caesar 05 German Output: </b>". $german_caesar05 ."<br>";
			echo "<b>Caesar 06 German Output: </b>". $german_caesar06 ."<br>";
			echo "<b>Caesar 07 German Output: </b>". $german_caesar07 ."<br>";
			echo "<b>Caesar 08 German Output: </b>". $german_caesar08 ."<br>";
			echo "<b>Caesar 09 German Output: </b>". $german_caesar09 ."<br>";
			echo "<b>Caesar 10 German Output: </b>". $german_caesar10 ."<br>";
			echo "<b>Caesar 11 German Output: </b>". $german_caesar11 ."<br>";
			echo "<b>Caesar 12 German Output: </b>". $german_caesar12 ."<br>";
			echo "<b>Caesar 13 German Output: </b>". $german_caesar13 ."<br>";
			echo "<b>Caesar 14 German Output: </b>". $german_caesar14 ."<br>";
			echo "<b>Caesar 15 German Output: </b>". $german_caesar15 ."<br>";
			echo "<b>Caesar 16 German Output: </b>". $german_caesar16 ."<br>";
			echo "<b>Caesar 17 German Output: </b>". $german_caesar17 ."<br>";
			echo "<b>Caesar 18 German Output: </b>". $german_caesar18 ."<br>";
			echo "<b>Caesar 19 German Output: </b>". $german_caesar19 ."<br>";
			echo "<b>Caesar 20 German Output: </b>". $german_caesar20 ."<br>";
			echo "<b>Caesar 21 German Output: </b>". $german_caesar21 ."<br>";
			echo "<b>Caesar 22 German Output: </b>". $german_caesar22 ."<br>";
			echo "<b>Caesar 23 German Output: </b>". $german_caesar23 ."<br>";
			echo "<b>Caesar 24 German Output: </b>". $german_caesar24 ."<br>";
			echo "<b>Caesar 25 German Output: </b>". $german_caesar25 ."</p>";

			echo "<p><b>Caesar 01 Spanish Output: </b>". $spanish_caesar01 ."<br>";
			echo "<b>Caesar 02 Spanish Output: </b>". $spanish_caesar02 ."<br>";
			echo "<b>Caesar 03 Spanish Output: </b>". $spanish_caesar03 ."<br>";
			echo "<b>Caesar 04 Spanish Output: </b>". $spanish_caesar04 ."<br>";
			echo "<b>Caesar 05 Spanish Output: </b>". $spanish_caesar05 ."<br>";
			echo "<b>Caesar 06 Spanish Output: </b>". $spanish_caesar06 ."<br>";
			echo "<b>Caesar 07 Spanish Output: </b>". $spanish_caesar07 ."<br>";
			echo "<b>Caesar 08 Spanish Output: </b>". $spanish_caesar08 ."<br>";
			echo "<b>Caesar 09 Spanish Output: </b>". $spanish_caesar09 ."<br>";
			echo "<b>Caesar 10 Spanish Output: </b>". $spanish_caesar10 ."<br>";
			echo "<b>Caesar 11 Spanish Output: </b>". $spanish_caesar11 ."<br>";
			echo "<b>Caesar 12 Spanish Output: </b>". $spanish_caesar12 ."<br>";
			echo "<b>Caesar 13 Spanish Output: </b>". $spanish_caesar13 ."<br>";
			echo "<b>Caesar 14 Spanish Output: </b>". $spanish_caesar14 ."<br>";
			echo "<b>Caesar 15 Spanish Output: </b>". $spanish_caesar15 ."<br>";
			echo "<b>Caesar 16 Spanish Output: </b>". $spanish_caesar16 ."<br>";
			echo "<b>Caesar 17 Spanish Output: </b>". $spanish_caesar17 ."<br>";
			echo "<b>Caesar 18 Spanish Output: </b>". $spanish_caesar18 ."<br>";
			echo "<b>Caesar 19 Spanish Output: </b>". $spanish_caesar19 ."<br>";
			echo "<b>Caesar 20 Spanish Output: </b>". $spanish_caesar20 ."<br>";
			echo "<b>Caesar 21 Spanish Output: </b>". $spanish_caesar21 ."<br>";
			echo "<b>Caesar 22 Spanish Output: </b>". $spanish_caesar22 ."<br>";
			echo "<b>Caesar 23 Spanish Output: </b>". $spanish_caesar23 ."<br>";
			echo "<b>Caesar 24 Spanish Output: </b>". $spanish_caesar24 ."<br>";
			echo "<b>Caesar 25 Spanish Output: </b>". $spanish_caesar25 ."</p>";
		}
		else { echo "<b>DB Query Failed! Job ID: </b>". $jobid ;}

		?>
		</p>
	</div>
</div>
<div class="body-wrapper body-bottom-margin">
	<p></p>
	<p>
		<a href="../brute-ocr-history" class="btn btn-warning">Return to Brute OCR History</a>
	</p>
</div>
<p></p>

</body>
</html>