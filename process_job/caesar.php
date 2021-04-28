<?php

/* CODE REFERENCED FROM https://www.programmingalgorithms.com/algorithm/caesar-cipher/php/ */

function Cipher($ch, $key)
{
	if (!ctype_alpha($ch))
		return $ch;

	$offset = ord(ctype_upper($ch) ? 'A' : 'a');
	return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
}

function Encipher($input, $key)
{
	$output = "";

	$inputArr = str_split($input);
	foreach ($inputArr as $ch)
		$output .= Cipher($ch, $key);

	return $output;
}


function startCaesarDecipher($caesarSet, $text_to_decipher){

	return Encipher($text_to_decipher, 26 - $caesarSet);
	
}

?>