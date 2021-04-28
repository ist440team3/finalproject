<?php

function startTranslator($target_language, $text_to_translate){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api-free.deepl.com/v2/translate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "auth_key=74ae777b-8455-8c31-41be-3854e0c69521:fx&text={$text_to_translate}&target_lang={$target_language}");

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$translatedWords = json_decode($result, true); // Decode the word
$result = $translatedWords['translations'][0]['text']; // Search the word

//sleep(1); //PAUSE FUNCTION FOR 1 SECOND

return $result;
}

?>