<?php
// Initialize the session
session_start();

$originalFileName = $_SESSION["uploadedFilename"];

//INCLUDE CONFIG FILE
require_once "../config.php";

//CREATE JOB ID AND INSERT USERID AND JOB TIMESTAMP
$currentUserId = $_SESSION["id"];
$createJobIdSql = "INSERT INTO job (job_id, usr_id, job_time_started) VALUES (NULL, {$currentUserId}, now())";
$createJobIdQuery = mysqli_query($link, $createJobIdSql);
if ($createJobIdQuery) { $jobid = $link->insert_id; }

//SET SESSION VARIABLE WITH JOB ID
$_SESSION["jobid"] = $jobid;

//CREATE LOGGING ID AND INSERT INTO JOB TABLE
$createLoggingIdSql = "INSERT INTO logging (log_id) VALUES (NULL)";
$createLoggingIdQuery = mysqli_query($link, $createLoggingIdSql);
if ($createLoggingIdQuery) { $logid = $link->insert_id; }
$updateJobWithLoggingIdSql = "UPDATE job SET log_id = {$logid} WHERE job_id = {$jobid}";
$updateJobWithLoggingIdQuery =  mysqli_query($link, $updateJobWithLoggingIdSql);

//CREATE USER IMAGE ID AND INSERT FILENAME
$createImgIdSql = "INSERT INTO user_image (usr_img_id, usr_img_orig_fname) VALUES (NULL, '$originalFileName')";
$createImgIdQuery = mysqli_query($link, $createImgIdSql);
if ($createImgIdQuery) { $imageid = $link->insert_id; }

//GET ORIGINAL IMAGE FILE PROPERTIES AND INSERT INTO DATABASE
$originalImagePath = "../upload/originals/$originalFileName";
$originalImageIM = new Imagick($originalImagePath);
$originalImageFormat = $originalImageIM->getImageMimeType();
$originalImageHeight = $originalImageIM->getImageHeight();
$originalImageWidth = $originalImageIM->getImageWidth();
$originalImageSize = filesize($originalImagePath);

$updateOrigImgSql  = "UPDATE user_image SET usr_img_orig_fformat = '{$originalImageFormat}', usr_img_orig_fsize = {$originalImageSize}, ";
$updateOrigImgSql .= "usr_img_orig_height = {$originalImageHeight}, usr_img_orig_width = {$originalImageWidth} WHERE usr_img_id = {$imageid}";
$updateOrigImgQuery = mysqli_query($link, $updateOrigImgSql);

//INSERT IMAGE ID INTO JOB TABLE
$updateJobWithImgIdSql = "UPDATE job SET usr_img_id = {$imageid} WHERE job_id = {$jobid}";
$updateJobWithImgIdQuery =  mysqli_query($link, $updateJobWithImgIdSql);

//CREATE NEW OPTIMIZED IMAGE
$optimizedImageIM = new Imagick($originalImagePath);

//RESIZE IMAGE IF IT IS UNDER 3000 PIXELS IN WIDTH AND/OR HEIGHT
if ($originalImageHeight < 3000 && $originalImageWidth < 3000) {
	if ($originalImageWidth > $originalImageHeight){
		$imageResizeFormula = 5000 / $originalImageWidth;
		$imageResizeMultiplier = number_format((float)$imageResizeFormula, 2, '.', '');
		$newImageWidth = intval($originalImageWidth * $imageResizeMultiplier);
		$newImageHeight = intval($originalImageHeight * $imageResizeMultiplier);
		$optimizedImageIM->scaleimage($newImageWidth, $newImageHeight);
	}
	else if ($originalImageHeight > $originalImageWidth){
		$imageResizeFormula = 5000 / $originalImageHeight;
		$imageResizeMultiplier = number_format((float)$imageResizeFormula, 2, '.', '');
		$newImageWidth = intval($originalImageWidth * $imageResizeMultiplier);
		$newImageHeight = intval($originalImageHeight * $imageResizeMultiplier);
		$optimizedImageIM->scaleimage($newImageWidth, $newImageHeight);
	}
	else if ($originalImageWidth == $originalImageHeight){
		$imageResizeFormula = 5000 / $originalImageWidth;
		$imageResizeMultiplier = number_format((float)$imageResizeFormula, 2, '.', '');
		$newImageWidth = intval($originalImageWidth * $imageResizeMultiplier);
		$newImageHeight = intval($originalImageHeight * $imageResizeMultiplier);
		$optimizedImageIM->scaleimage($newImageWidth, $newImageHeight);
	}
}

//PERFORM IMAGE OPTIMIZATION
$optimizedImageIM->brightnessContrastImage(10, 5, Imagick::CHANNEL_DEFAULT);
$optimizedImageIM->setImageBackgroundColor('white');
$optimizedImageIM->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
$optimizedImageIM->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
$optimizedImageIM->setImageFormat('tiff');
file_put_contents ("../upload/optimized/".$imageid.".tif", $optimizedImageIM);

//UPDATE IMAGE TABLE IN DATABASE WITH OPTIMIZED IMAGE INFORMATION
$optimizedImageFormat = $optimizedImageIM->getImageMimeType();
$optimizedImageHeight = $optimizedImageIM->getImageHeight();
$optimizedImageWidth = $optimizedImageIM->getImageWidth();
$optimizedImagePath = "../upload/optimized/".$imageid.".tif";
$optimizedImageFileName = $imageid.".tif";
$optimizedImageSize = filesize($optimizedImagePath);

$updateOptImgSql  = "UPDATE user_image SET usr_img_opt_fformat = '{$optimizedImageFormat}', usr_img_opt_fsize = {$optimizedImageSize}, usr_img_opt_fname = '{$optimizedImageFileName}', ";
$updateOptImgSql .= "usr_img_opt_height = {$optimizedImageHeight}, usr_img_opt_width = {$optimizedImageWidth} WHERE usr_img_id = {$imageid}";
$updateOptImgQuery = mysqli_query($link, $updateOptImgSql);

//PERFORM TESSERACT OCR ON OPTIMIZED IMAGE
exec("/usr/bin/tesseract ".$optimizedImagePath." stdout", $ocrProcessing);
$ocrOutput = strval($ocrProcessing[0]);

//CREATE OCR ID AND OCR TEXT
$createOcrIdSql = "INSERT INTO ocr (ocr_id, ocr_txt_output) VALUES (NULL, '$ocrOutput')";
$createOcrIdQuery = mysqli_query($link, $createOcrIdSql);
if ($createOcrIdQuery) { $ocrid = $link->insert_id; }

//INSERT OCR ID INTO JOB TABLE
$updateJobWithOcrIdSql = "UPDATE job SET ocr_id = {$ocrid} WHERE job_id = {$jobid}";
$updateJobWithOcrIdQuery =  mysqli_query($link, $updateJobWithOcrIdSql);

//CREATE BRUTE ID AND INSERT INTO JOB TABLE
$createBruteIdSql = "INSERT INTO bruteforce (brute_id) VALUES (NULL)";
$createBruteIdQuery = mysqli_query($link, $createBruteIdSql);
if ($createBruteIdQuery) { $bruteid = $link->insert_id; }
$updateJobWithBruteIdSql = "UPDATE job SET brute_id = {$bruteid} WHERE job_id = {$jobid}";
$updateJobWithBruteIdQuery =  mysqli_query($link, $updateJobWithBruteIdSql);

//CREATE TRANSLATE ID AND INSERT INTO JOB TABLE
$createTranslateIdSql = "INSERT INTO lang_translate (translate_id) VALUES (NULL)";
$createTranslateIdQuery = mysqli_query($link, $createTranslateIdSql);
if ($createTranslateIdQuery) { $translateid = $link->insert_id; }
$updateJobWithTranslateIdSql = "UPDATE job SET translate_id = {$translateid} WHERE job_id = {$jobid}";
$updateJobWithTranslateIdQuery =  mysqli_query($link, $updateJobWithTranslateIdSql);

//INCLUDE BRUTEFORCE DECIPHER SCRIPTS
require_once "./atbash.php";
require_once "./bacon.php";
require_once "./caesar.php";

//EXECUTE ATBASH DECIPHER ON OCR TXT OUTPUT
$atBashOutput = startAtBashDecipher($ocrOutput);

//INSERT ATBASH OUTPUT INTO DATABASE
$updateAtbashSql = "UPDATE bruteforce SET atbash = ('$atBashOutput') WHERE brute_id = {$bruteid}";
$updateAtbashQuery = mysqli_query($link, $updateAtbashSql);

//EXECUTE BACON DECIPHER ON OCR TXT OUTPUT
$baconOutput = startBaconDecipher($ocrOutput);

//INSERT BACON OUTPUT INTO DATABASE
$updateBaconSql = "UPDATE bruteforce SET bacon = ('$baconOutput') WHERE brute_id = {$bruteid}";
$updateBaconQuery = mysqli_query($link, $updateBaconSql);

//EXECUTE CAESAR DECIPHER ON OCR TXT OUTPUT
$caesarOutput01 = startCaesarDecipher(1, $ocrOutput);
$caesarOutput02 = startCaesarDecipher(2, $ocrOutput);
$caesarOutput03 = startCaesarDecipher(3, $ocrOutput);
$caesarOutput04 = startCaesarDecipher(4, $ocrOutput);
$caesarOutput05 = startCaesarDecipher(5, $ocrOutput);
$caesarOutput06 = startCaesarDecipher(6, $ocrOutput);
$caesarOutput07 = startCaesarDecipher(7, $ocrOutput);
$caesarOutput08 = startCaesarDecipher(8, $ocrOutput);
$caesarOutput09 = startCaesarDecipher(9, $ocrOutput);
$caesarOutput10 = startCaesarDecipher(10, $ocrOutput);
$caesarOutput11 = startCaesarDecipher(11, $ocrOutput);
$caesarOutput12 = startCaesarDecipher(12, $ocrOutput);
$caesarOutput13 = startCaesarDecipher(13, $ocrOutput);
$caesarOutput14 = startCaesarDecipher(14, $ocrOutput);
$caesarOutput15 = startCaesarDecipher(15, $ocrOutput);
$caesarOutput16 = startCaesarDecipher(16, $ocrOutput);
$caesarOutput17 = startCaesarDecipher(17, $ocrOutput);
$caesarOutput18 = startCaesarDecipher(18, $ocrOutput);
$caesarOutput19 = startCaesarDecipher(19, $ocrOutput);
$caesarOutput20 = startCaesarDecipher(20, $ocrOutput);
$caesarOutput21 = startCaesarDecipher(21, $ocrOutput);
$caesarOutput22 = startCaesarDecipher(22, $ocrOutput);
$caesarOutput23 = startCaesarDecipher(23, $ocrOutput);
$caesarOutput24 = startCaesarDecipher(24, $ocrOutput);
$caesarOutput25 = startCaesarDecipher(25, $ocrOutput);

//INSERT CAESAR OUTPUT INTO DATABASE
$updateCaesar01Sql = "UPDATE bruteforce SET c01 = ('$caesarOutput01') WHERE brute_id = {$bruteid}";
$updateCaesar01Query = mysqli_query($link, $updateCaesar01Sql);
$updateCaesar02Sql = "UPDATE bruteforce SET c02 = ('$caesarOutput02') WHERE brute_id = {$bruteid}";
$updateCaesar02Query = mysqli_query($link, $updateCaesar02Sql);
$updateCaesar03Sql = "UPDATE bruteforce SET c03 = ('$caesarOutput03') WHERE brute_id = {$bruteid}";
$updateCaesar03Query = mysqli_query($link, $updateCaesar03Sql);
$updateCaesar04Sql = "UPDATE bruteforce SET c04 = ('$caesarOutput04') WHERE brute_id = {$bruteid}";
$updateCaesar04Query = mysqli_query($link, $updateCaesar04Sql);
$updateCaesar05Sql = "UPDATE bruteforce SET c05 = ('$caesarOutput05') WHERE brute_id = {$bruteid}";
$updateCaesar05Query = mysqli_query($link, $updateCaesar05Sql);
$updateCaesar06Sql = "UPDATE bruteforce SET c06 = ('$caesarOutput06') WHERE brute_id = {$bruteid}";
$updateCaesar06Query = mysqli_query($link, $updateCaesar06Sql);
$updateCaesar07Sql = "UPDATE bruteforce SET c07 = ('$caesarOutput07') WHERE brute_id = {$bruteid}";
$updateCaesar07Query = mysqli_query($link, $updateCaesar07Sql);
$updateCaesar08Sql = "UPDATE bruteforce SET c08 = ('$caesarOutput08') WHERE brute_id = {$bruteid}";
$updateCaesar08Query = mysqli_query($link, $updateCaesar08Sql);
$updateCaesar09Sql = "UPDATE bruteforce SET c09 = ('$caesarOutput09') WHERE brute_id = {$bruteid}";
$updateCaesar09Query = mysqli_query($link, $updateCaesar09Sql);
$updateCaesar10Sql = "UPDATE bruteforce SET c10 = ('$caesarOutput10') WHERE brute_id = {$bruteid}";
$updateCaesar10Query = mysqli_query($link, $updateCaesar10Sql);
$updateCaesar11Sql = "UPDATE bruteforce SET c11 = ('$caesarOutput11') WHERE brute_id = {$bruteid}";
$updateCaesar11Query = mysqli_query($link, $updateCaesar11Sql);
$updateCaesar12Sql = "UPDATE bruteforce SET c12 = ('$caesarOutput12') WHERE brute_id = {$bruteid}";
$updateCaesar12Query = mysqli_query($link, $updateCaesar12Sql);
$updateCaesar13Sql = "UPDATE bruteforce SET c13 = ('$caesarOutput13') WHERE brute_id = {$bruteid}";
$updateCaesar13Query = mysqli_query($link, $updateCaesar13Sql);
$updateCaesar14Sql = "UPDATE bruteforce SET c14 = ('$caesarOutput14') WHERE brute_id = {$bruteid}";
$updateCaesar14Query = mysqli_query($link, $updateCaesar14Sql);
$updateCaesar15Sql = "UPDATE bruteforce SET c15 = ('$caesarOutput15') WHERE brute_id = {$bruteid}";
$updateCaesar15Query = mysqli_query($link, $updateCaesar15Sql);
$updateCaesar16Sql = "UPDATE bruteforce SET c16 = ('$caesarOutput16') WHERE brute_id = {$bruteid}";
$updateCaesar16Query = mysqli_query($link, $updateCaesar16Sql);
$updateCaesar17Sql = "UPDATE bruteforce SET c17 = ('$caesarOutput17') WHERE brute_id = {$bruteid}";
$updateCaesar17Query = mysqli_query($link, $updateCaesar17Sql);
$updateCaesar18Sql = "UPDATE bruteforce SET c18 = ('$caesarOutput18') WHERE brute_id = {$bruteid}";
$updateCaesar18Query = mysqli_query($link, $updateCaesar18Sql);
$updateCaesar19Sql = "UPDATE bruteforce SET c19 = ('$caesarOutput19') WHERE brute_id = {$bruteid}";
$updateCaesar19Query = mysqli_query($link, $updateCaesar19Sql);
$updateCaesar20Sql = "UPDATE bruteforce SET c20 = ('$caesarOutput20') WHERE brute_id = {$bruteid}";
$updateCaesar20Query = mysqli_query($link, $updateCaesar20Sql);
$updateCaesar21Sql = "UPDATE bruteforce SET c21 = ('$caesarOutput21') WHERE brute_id = {$bruteid}";
$updateCaesar21Query = mysqli_query($link, $updateCaesar21Sql);
$updateCaesar22Sql = "UPDATE bruteforce SET c22 = ('$caesarOutput22') WHERE brute_id = {$bruteid}";
$updateCaesar22Query = mysqli_query($link, $updateCaesar22Sql);
$updateCaesar23Sql = "UPDATE bruteforce SET c23 = ('$caesarOutput23') WHERE brute_id = {$bruteid}";
$updateCaesar23Query = mysqli_query($link, $updateCaesar23Sql);
$updateCaesar24Sql = "UPDATE bruteforce SET c24 = ('$caesarOutput24') WHERE brute_id = {$bruteid}";
$updateCaesar24Query = mysqli_query($link, $updateCaesar24Sql);
$updateCaesar25Sql = "UPDATE bruteforce SET c25 = ('$caesarOutput25') WHERE brute_id = {$bruteid}";
$updateCaesar25Query = mysqli_query($link, $updateCaesar25Sql);

//CREATE LANGUAGE TRANSLATION IDS AND INSERT INTO TRANSLATE TABLE
$createGermanTranslateIdSql = "INSERT INTO lang_german (lang_german_id) VALUES (NULL)";
$createGermanTranslateIdQuery = mysqli_query($link, $createGermanTranslateIdSql);
if ($createGermanTranslateIdQuery) { $germantranslateid = $link->insert_id; }
$updateLangWithGermanTranslateIdSql = "UPDATE lang_translate SET lang_german_id = {$germantranslateid} WHERE translate_id = {$translateid}";
$updateLangWithGermanTranslateIdQuery =  mysqli_query($link, $updateLangWithGermanTranslateIdSql);

$createEnglishTranslateIdSql = "INSERT INTO lang_english (lang_english_id) VALUES (NULL)";
$createEnglishTranslateIdQuery = mysqli_query($link, $createEnglishTranslateIdSql);
if ($createEnglishTranslateIdQuery) { $englishtranslateid = $link->insert_id; }
$updateLangWithEnglishTranslateIdSql = "UPDATE lang_translate SET lang_english_id = {$englishtranslateid} WHERE translate_id = {$translateid}";
$updateLangWithEnglishTranslateIdQuery =  mysqli_query($link, $updateLangWithEnglishTranslateIdSql);

$createFrenchTranslateIdSql = "INSERT INTO lang_french (lang_french_id) VALUES (NULL)";
$createFrenchTranslateIdQuery = mysqli_query($link, $createFrenchTranslateIdSql);
if ($createFrenchTranslateIdQuery) { $frenchtranslateid = $link->insert_id; }
$updateLangWithFrenchTranslateIdSql = "UPDATE lang_translate SET lang_french_id = {$frenchtranslateid} WHERE translate_id = {$translateid}";
$updateLangWithFrenchTranslateIdQuery =  mysqli_query($link, $updateLangWithFrenchTranslateIdSql);

$createSpanishTranslateIdSql = "INSERT INTO lang_spanish (lang_spanish_id) VALUES (NULL)";
$createSpanishTranslateIdQuery = mysqli_query($link, $createSpanishTranslateIdSql);
if ($createSpanishTranslateIdQuery) { $spanishtranslateid = $link->insert_id; }
$updateLangWithSpanishTranslateIdSql = "UPDATE lang_translate SET lang_spanish_id = {$spanishtranslateid} WHERE translate_id = {$translateid}";
$updateLangWithSpanishTranslateIdQuery =  mysqli_query($link, $updateLangWithSpanishTranslateIdSql);

//INCLUDE TRANSLATION SCRIPT
require_once "./translator.php";

//TRANSLATE ALL OUTPUTS TO GERMAN
$de_orig = startTranslator("de", $ocrOutput);
$de_atbash = startTranslator("de", $atBashOutput);
$de_bacon = startTranslator("de", $baconOutput);
$de_c01 = startTranslator("de", $caesarOutput01);
$de_c02 = startTranslator("de", $caesarOutput02);
$de_c03 = startTranslator("de", $caesarOutput03);
$de_c04 = startTranslator("de", $caesarOutput04);
$de_c05 = startTranslator("de", $caesarOutput05);
$de_c06 = startTranslator("de", $caesarOutput06);
$de_c07 = startTranslator("de", $caesarOutput07);
$de_c08 = startTranslator("de", $caesarOutput08);
$de_c09 = startTranslator("de", $caesarOutput09);
$de_c10 = startTranslator("de", $caesarOutput10);
$de_c11 = startTranslator("de", $caesarOutput11);
$de_c12 = startTranslator("de", $caesarOutput12);
$de_c13 = startTranslator("de", $caesarOutput13);
$de_c14 = startTranslator("de", $caesarOutput14);
$de_c15 = startTranslator("de", $caesarOutput15);
$de_c16 = startTranslator("de", $caesarOutput16);
$de_c17 = startTranslator("de", $caesarOutput17);
$de_c18 = startTranslator("de", $caesarOutput18);
$de_c19 = startTranslator("de", $caesarOutput19);
$de_c20 = startTranslator("de", $caesarOutput20);
$de_c21 = startTranslator("de", $caesarOutput21);
$de_c22 = startTranslator("de", $caesarOutput22);
$de_c23 = startTranslator("de", $caesarOutput23);
$de_c24 = startTranslator("de", $caesarOutput24);
$de_c25 = startTranslator("de", $caesarOutput25);

//INSERT GERMAN TRANSLATIONS INTO GERMAN LANGUAGE TABLE
$updateGermanTranslationSql  = "UPDATE lang_german SET de_orig = ('$de_orig'), de_atbash = ('$de_atbash'), de_bacon = ('$de_bacon'), ";
$updateGermanTranslationSql .= "de_c01 = ('$de_c01'), de_c02 = ('$de_c02'), de_c03 = ('$de_c03'), de_c04 = ('$de_c04'), de_c05 = ('$de_c05'), de_c06 = ('$de_c06'), de_c07 = ('$de_c07'), ";
$updateGermanTranslationSql .= "de_c08 = ('$de_c08'), de_c09 = ('$de_c09'), de_c10 = ('$de_c10'), de_c11 = ('$de_c11'), de_c12 = ('$de_c12'), de_c13 = ('$de_c13'), de_c14 = ('$de_c14'), ";
$updateGermanTranslationSql .= "de_c15 = ('$de_c15'), de_c16 = ('$de_c16'), de_c17 = ('$de_c17'), de_c18 = ('$de_c18'), de_c19 = ('$de_c19'), de_c20 = ('$de_c20'), de_c21 = ('$de_c21'), ";
$updateGermanTranslationSql .= "de_c22 = ('$de_c22'), de_c23 = ('$de_c23'), de_c24 = ('$de_c24'), de_c25 = ('$de_c25') WHERE lang_german_id = {$germantranslateid}";
$updateGermanTranslationQuery = mysqli_query($link, $updateGermanTranslationSql);

//TRANSLATE ALL OUTPUTS TO ENGLISH
$en_orig = startTranslator("en", $ocrOutput);
$en_atbash = startTranslator("en", $atBashOutput);
$en_bacon = startTranslator("en", $baconOutput);
$en_c01 = startTranslator("en", $caesarOutput01);
$en_c02 = startTranslator("en", $caesarOutput02);
$en_c03 = startTranslator("en", $caesarOutput03);
$en_c04 = startTranslator("en", $caesarOutput04);
$en_c05 = startTranslator("en", $caesarOutput05);
$en_c06 = startTranslator("en", $caesarOutput06);
$en_c07 = startTranslator("en", $caesarOutput07);
$en_c08 = startTranslator("en", $caesarOutput08);
$en_c09 = startTranslator("en", $caesarOutput09);
$en_c10 = startTranslator("en", $caesarOutput10);
$en_c11 = startTranslator("en", $caesarOutput11);
$en_c12 = startTranslator("en", $caesarOutput12);
$en_c13 = startTranslator("en", $caesarOutput13);
$en_c14 = startTranslator("en", $caesarOutput14);
$en_c15 = startTranslator("en", $caesarOutput15);
$en_c16 = startTranslator("en", $caesarOutput16);
$en_c17 = startTranslator("en", $caesarOutput17);
$en_c18 = startTranslator("en", $caesarOutput18);
$en_c19 = startTranslator("en", $caesarOutput19);
$en_c20 = startTranslator("en", $caesarOutput20);
$en_c21 = startTranslator("en", $caesarOutput21);
$en_c22 = startTranslator("en", $caesarOutput22);
$en_c23 = startTranslator("en", $caesarOutput23);
$en_c24 = startTranslator("en", $caesarOutput24);
$en_c25 = startTranslator("en", $caesarOutput25);

//INSERT ENGLISH TRANSLATIONS INTO ENGLISH LANGUAGE TABLE
$updateEnglishTranslationSql  = "UPDATE lang_english SET en_orig = ('$en_orig'), en_atbash = ('$en_atbash'), en_bacon = ('$en_bacon'), ";
$updateEnglishTranslationSql .= "en_c01 = ('$en_c01'), en_c02 = ('$en_c02'), en_c03 = ('$en_c03'), en_c04 = ('$en_c04'), en_c05 = ('$en_c05'), en_c06 = ('$en_c06'), en_c07 = ('$en_c07'), ";
$updateEnglishTranslationSql .= "en_c08 = ('$en_c08'), en_c09 = ('$en_c09'), en_c10 = ('$en_c10'), en_c11 = ('$en_c11'), en_c12 = ('$en_c12'), en_c13 = ('$en_c13'), en_c14 = ('$en_c14'), ";
$updateEnglishTranslationSql .= "en_c15 = ('$en_c15'), en_c16 = ('$en_c16'), en_c17 = ('$en_c17'), en_c18 = ('$en_c18'), en_c19 = ('$en_c19'), en_c20 = ('$en_c20'), en_c21 = ('$en_c21'), ";
$updateEnglishTranslationSql .= "en_c22 = ('$en_c22'), en_c23 = ('$en_c23'), en_c24 = ('$en_c24'), en_c25 = ('$en_c25') WHERE lang_english_id = {$englishtranslateid}";
$updateEnglishTranslationQuery = mysqli_query($link, $updateEnglishTranslationSql);

//TRANSLATE ALL OUTPUTS TO SPANISH
$es_orig = startTranslator("es", $ocrOutput);
$es_atbash = startTranslator("es", $atBashOutput);
$es_bacon = startTranslator("es", $baconOutput);
$es_c01 = startTranslator("es", $caesarOutput01);
$es_c02 = startTranslator("es", $caesarOutput02);
$es_c03 = startTranslator("es", $caesarOutput03);
$es_c04 = startTranslator("es", $caesarOutput04);
$es_c05 = startTranslator("es", $caesarOutput05);
$es_c06 = startTranslator("es", $caesarOutput06);
$es_c07 = startTranslator("es", $caesarOutput07);
$es_c08 = startTranslator("es", $caesarOutput08);
$es_c09 = startTranslator("es", $caesarOutput09);
$es_c10 = startTranslator("es", $caesarOutput10);
$es_c11 = startTranslator("es", $caesarOutput11);
$es_c12 = startTranslator("es", $caesarOutput12);
$es_c13 = startTranslator("es", $caesarOutput13);
$es_c14 = startTranslator("es", $caesarOutput14);
$es_c15 = startTranslator("es", $caesarOutput15);
$es_c16 = startTranslator("es", $caesarOutput16);
$es_c17 = startTranslator("es", $caesarOutput17);
$es_c18 = startTranslator("es", $caesarOutput18);
$es_c19 = startTranslator("es", $caesarOutput19);
$es_c20 = startTranslator("es", $caesarOutput20);
$es_c21 = startTranslator("es", $caesarOutput21);
$es_c22 = startTranslator("es", $caesarOutput22);
$es_c23 = startTranslator("es", $caesarOutput23);
$es_c24 = startTranslator("es", $caesarOutput24);
$es_c25 = startTranslator("es", $caesarOutput25);

//INSERT SPANISH TRANSLATIONS INTO SPANISH LANGUAGE TABLE
$updateSpanishTranslationSql  = "UPDATE lang_spanish SET es_orig = ('$es_orig'), es_atbash = ('$es_atbash'), es_bacon = ('$es_bacon'), ";
$updateSpanishTranslationSql .= "es_c01 = ('$es_c01'), es_c02 = ('$es_c02'), es_c03 = ('$es_c03'), es_c04 = ('$es_c04'), es_c05 = ('$es_c05'), es_c06 = ('$es_c06'), es_c07 = ('$es_c07'), ";
$updateSpanishTranslationSql .= "es_c08 = ('$es_c08'), es_c09 = ('$es_c09'), es_c10 = ('$es_c10'), es_c11 = ('$es_c11'), es_c12 = ('$es_c12'), es_c13 = ('$es_c13'), es_c14 = ('$es_c14'), ";
$updateSpanishTranslationSql .= "es_c15 = ('$es_c15'), es_c16 = ('$es_c16'), es_c17 = ('$es_c17'), es_c18 = ('$es_c18'), es_c19 = ('$es_c19'), es_c20 = ('$es_c20'), es_c21 = ('$es_c21'), ";
$updateSpanishTranslationSql .= "es_c22 = ('$es_c22'), es_c23 = ('$es_c23'), es_c24 = ('$es_c24'), es_c25 = ('$es_c25') WHERE lang_spanish_id = {$spanishtranslateid}";
$updateSpanishTranslationQuery = mysqli_query($link, $updateSpanishTranslationSql);

//TRANSLATE ALL OUTPUTS TO FRENCH
$fr_orig = startTranslator("fr", $ocrOutput);
$fr_atbash = startTranslator("fr", $atBashOutput);
$fr_bacon = startTranslator("fr", $baconOutput);
$fr_c01 = startTranslator("fr", $caesarOutput01);
$fr_c02 = startTranslator("fr", $caesarOutput02);
$fr_c03 = startTranslator("fr", $caesarOutput03);
$fr_c04 = startTranslator("fr", $caesarOutput04);
$fr_c05 = startTranslator("fr", $caesarOutput05);
$fr_c06 = startTranslator("fr", $caesarOutput06);
$fr_c07 = startTranslator("fr", $caesarOutput07);
$fr_c08 = startTranslator("fr", $caesarOutput08);
$fr_c09 = startTranslator("fr", $caesarOutput09);
$fr_c10 = startTranslator("fr", $caesarOutput10);
$fr_c11 = startTranslator("fr", $caesarOutput11);
$fr_c12 = startTranslator("fr", $caesarOutput12);
$fr_c13 = startTranslator("fr", $caesarOutput13);
$fr_c14 = startTranslator("fr", $caesarOutput14);
$fr_c15 = startTranslator("fr", $caesarOutput15);
$fr_c16 = startTranslator("fr", $caesarOutput16);
$fr_c17 = startTranslator("fr", $caesarOutput17);
$fr_c18 = startTranslator("fr", $caesarOutput18);
$fr_c19 = startTranslator("fr", $caesarOutput19);
$fr_c20 = startTranslator("fr", $caesarOutput20);
$fr_c21 = startTranslator("fr", $caesarOutput21);
$fr_c22 = startTranslator("fr", $caesarOutput22);
$fr_c23 = startTranslator("fr", $caesarOutput23);
$fr_c24 = startTranslator("fr", $caesarOutput24);
$fr_c25 = startTranslator("fr", $caesarOutput25);

//INSERT FRENCH TRANSLATIONS INTO FRENCH LANGUAGE TABLE
$updateFrenchTranslationSql  = "UPDATE lang_french SET fr_orig = ('$fr_orig'), fr_atbash = ('$fr_atbash'), fr_bacon = ('$fr_bacon'), ";
$updateFrenchTranslationSql .= "fr_c01 = ('$fr_c01'), fr_c02 = ('$fr_c02'), fr_c03 = ('$fr_c03'), fr_c04 = ('$fr_c04'), fr_c05 = ('$fr_c05'), fr_c06 = ('$fr_c06'), fr_c07 = ('$fr_c07'), ";
$updateFrenchTranslationSql .= "fr_c08 = ('$fr_c08'), fr_c09 = ('$fr_c09'), fr_c10 = ('$fr_c10'), fr_c11 = ('$fr_c11'), fr_c12 = ('$fr_c12'), fr_c13 = ('$fr_c13'), fr_c14 = ('$fr_c14'), ";
$updateFrenchTranslationSql .= "fr_c15 = ('$fr_c15'), fr_c16 = ('$fr_c16'), fr_c17 = ('$fr_c17'), fr_c18 = ('$fr_c18'), fr_c19 = ('$fr_c19'), fr_c20 = ('$fr_c20'), fr_c21 = ('$fr_c21'), ";
$updateFrenchTranslationSql .= "fr_c22 = ('$fr_c22'), fr_c23 = ('$fr_c23'), fr_c24 = ('$fr_c24'), fr_c25 = ('$fr_c25') WHERE lang_french_id = {$frenchtranslateid}";
$updateFrenchTranslationQuery = mysqli_query($link, $updateFrenchTranslationSql);

//INSERT END OF JOB TIMESTAMP INTO JOB TABLE
$updateJobWithEndJobTimestampSql = "UPDATE job SET job_time_ended = (now()) WHERE job_id = {$jobid}";
$updateJobWithEndJobTimestampQuery =  mysqli_query($link, $updateJobWithEndJobTimestampSql);

//LOAD THE JOB SUMMARY PAGE
echo "<form id='job_processing_complete' action='../job_summary/index.php' method='post'>";
echo "<input type='hidden' name='jobToDisplay' value='$jobid'>";
echo "</form>";
echo "<script type='text/javascript'> document.getElementById('job_processing_complete').submit(); </script>";

exit();
?>