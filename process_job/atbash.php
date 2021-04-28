<?php

function startAtBashDecipher($text_to_decipher){

//	$atbashOutput = "Text " .$text_to_decipher. " ATBASH";
	$atbashArray = str_split($text_to_decipher);
	$atbashArraySize = count($atbashArray);
	$atbashOutput = "";
	
	for($x = 0; $x <= $atbashArraySize; $x++)
	{
		if($atbashArray[$x] == "z"){$atbashOutput .= "a";}
			elseif ($atbashArray[$x] == "y"){$atbashOutput .= "b";}
			elseif ($atbashArray[$x] == "x"){$atbashOutput .= "c";}
			elseif ($atbashArray[$x] == "w"){$atbashOutput .= "d";}
			elseif ($atbashArray[$x] == "v"){$atbashOutput .= "e";}
			elseif ($atbashArray[$x] == "u"){$atbashOutput .= "f";}
			elseif ($atbashArray[$x] == "t"){$atbashOutput .= "g";}
			elseif ($atbashArray[$x] == "s"){$atbashOutput .= "h";}
			elseif ($atbashArray[$x] == "r"){$atbashOutput .= "i";}
			elseif ($atbashArray[$x] == "q"){$atbashOutput .= "j";}
			elseif ($atbashArray[$x] == "p"){$atbashOutput .= "k";}
			elseif ($atbashArray[$x] == "o"){$atbashOutput .= "l";}
			elseif ($atbashArray[$x] == "n"){$atbashOutput .= "m";}
			elseif ($atbashArray[$x] == "m"){$atbashOutput .= "n";}
			elseif ($atbashArray[$x] == "l"){$atbashOutput .= "o";}
			elseif ($atbashArray[$x] == "k"){$atbashOutput .= "p";}
			elseif ($atbashArray[$x] == "j"){$atbashOutput .= "q";}
			elseif ($atbashArray[$x] == "i"){$atbashOutput .= "r";}
			elseif ($atbashArray[$x] == "h"){$atbashOutput .= "s";}
			elseif ($atbashArray[$x] == "g"){$atbashOutput .= "t";}
			elseif ($atbashArray[$x] == "f"){$atbashOutput .= "u";}
			elseif ($atbashArray[$x] == "e"){$atbashOutput .= "v";}
			elseif ($atbashArray[$x] == "d"){$atbashOutput .= "w";}
			elseif ($atbashArray[$x] == "c"){$atbashOutput .= "x";}
			elseif ($atbashArray[$x] == "b"){$atbashOutput .= "y";}
			elseif ($atbashArray[$x] == "a"){$atbashOutput .= "z";}
			else {$atbashOutput .= $atbashArray[$x];}
	}
	
	return $atbashOutput;
}



?>