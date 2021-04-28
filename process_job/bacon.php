<?php

function startBaconDecipher($text_to_decipher){

$baconArray = str_split($text_to_decipher);
$baconArraySize = count($baconArray);
$baconOutput = "";	//SET BACON RETURN VARIABLE OUTPUT TO EMPTY
$baconSet = "";  //SET BACON LETTER GROUP TO EMPTY

for($x = 0; $x <= $baconArraySize; $x++)
	{
		if($baconArray[$x] == "a") {$baconSet .= "a";}
		elseif($baconArray[$x] == "b") {$baconSet .= "b";}
		else {$baconOutput .= $baconArray[$x]; }
		
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
			
			$baconSet = ""; //RESET BACON LETTER GROUP TO EMPTY
		}
	}

return $baconOutput;

}

?>