<?php

function baconCipher($input){

$text = $input;
$array = str_split($text);
$z = count($array);	//NUMBER OF CHARACTERS SPLIT IN ARRAY

	for($x = 0; $x <= $z; $x++)
	{
		echo $x ." - " . $array[$x] . " <br>";
	}



	for($x = 0; $x <= $z; $x++)
	{
		if($array[$x] == "a"){echo "aaaaa";}
			elseif ($array[$x] == "b"){echo "aaaab";}
			elseif ($array[$x] == "c"){echo "aaaba";}
			elseif ($array[$x] == "d"){echo "aaabb";}
			elseif ($array[$x] == "e"){echo "aabaa";}
			elseif ($array[$x] == "f"){echo "aabab";}
			elseif ($array[$x] == "g"){echo "aabba";}
			elseif ($array[$x] == "h"){echo "aabbb";}
			elseif ($array[$x] == "i"){echo "abaaa";}
			elseif ($array[$x] == "j"){echo "abaab";}
			elseif ($array[$x] == "k"){echo "ababa";}
			elseif ($array[$x] == "l"){echo "ababb";}
			elseif ($array[$x] == "m"){echo "abbaa";}
			elseif ($array[$x] == "n"){echo "abbab";}
			elseif ($array[$x] == "o"){echo "abbba";}
			elseif ($array[$x] == "p"){echo "abbbb";}
			elseif ($array[$x] == "q"){echo "baaaa";}
			elseif ($array[$x] == "r"){echo "baaab";}
			elseif ($array[$x] == "s"){echo "baaba";}
			elseif ($array[$x] == "t"){echo "baabb";}
			elseif ($array[$x] == "u"){echo "babaa";}
			elseif ($array[$x] == "v"){echo "babab";}
			elseif ($array[$x] == "w"){echo "babba";}
			elseif ($array[$x] == "x"){echo "babbb";}
			elseif ($array[$x] == "y"){echo "bbaaa";}
			elseif ($array[$x] == "z"){echo "bbaab";}
			else {echo $array[$x];}
	}
}




function baconDeCipher($input){

$text = $input;
$array = str_split($text);
$z = count($array);	//NUMBER OF CHARACTERS SPLIT IN ARRAY
$baconOutput = "";	//SET BACON RETURN VARIABLE OUTPUT TO EMPTY
$baconSet = "";  //SET BACON LETTER GROUP TO EMPTY

for($x = 0; $x <= $z; $x++)
	{
		if($array[$x] == "a") {$baconSet .= "a";}
		elseif($array[$x] == "b") {$baconSet .= "b";}
		else {$baconOutput .= $array[$x]; }
		
		if(strlen($baconSet) == 5){
			if($baconSet == "aaaaa"){$baconOutput .= "a";}
			elseif($baconSet == "aaaab"){$baconOutput .= "b";}
			elseif ($baconSet == "aaaba"){$baconOutput .= "c";}
			elseif ($baconSet == "aaabb"){$baconOutput .= "d";}
			elseif ($baconSet == "aabaa"){$baconOutput .= "e";}
			elseif ($baconSet == "aabab"){$baconOutput .= "f";}
			elseif ($baconSet == "aabba"){$baconOutput .= "g";}
			elseif ($baconSet == "aabbb"){$baconOutput .= "h";}
			elseif ($baconSet == "abaaa"){$baconOutput .= "i";}
			elseif ($baconSet == "abaab"){$baconOutput .= "j";}
			elseif ($baconSet == "ababa"){$baconOutput .= "k";}
			elseif ($baconSet == "ababb"){$baconOutput .= "l";}
			elseif ($baconSet == "abbaa"){$baconOutput .= "m";}
			elseif ($baconSet == "abbab"){$baconOutput .= "n";}
			elseif ($baconSet == "abbba"){$baconOutput .= "o";}
			elseif ($baconSet == "abbbb"){$baconOutput .= "p";}
			elseif ($baconSet == "baaaa"){$baconOutput .= "q";}
			elseif ($baconSet == "baaab"){$baconOutput .= "r";}
			elseif ($baconSet == "baaba"){$baconOutput .= "s";}
			elseif ($baconSet == "baabb"){$baconOutput .= "t";}
			elseif ($baconSet == "babaa"){$baconOutput .= "u";}
			elseif ($baconSet == "babab"){$baconOutput .= "v";}
			elseif ($baconSet == "babba"){$baconOutput .= "w";}
			elseif ($baconSet == "babbb"){$baconOutput .= "x";}
			elseif ($baconSet == "bbaaa"){$baconOutput .= "y";}
			elseif ($baconSet == "bbaab"){$baconOutput .= "z";}
			$baconSet = "";
		}
	}

return $baconOutput;

}





?>

<html><head></head><body>

Encrypted Bacon: <br> <?php  baconCipher('do or do not there is no try'); ?> <br><p>
Decrypted Bacon: <br> <?php  echo baconDeCipher('babbaaabaa ababbabbbabababaabaa abbbababaabaaab abaaabaababaabb aaabaaaaaaabbbbbaababaabbabbbaabbabaabaa abbbbbaaababbbaabaabaabaaaaababaabb'); ?> </p>

</body></html>
