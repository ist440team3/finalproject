<?php

function AtbashCipher($input){

$text = $input;
$array = str_split($text);
$z = count($array);	//NUMBER OF CHARACTERS SPLIT IN ARRAY

	for($x = 0; $x <= $z; $x++)
	{
		echo $x ." - " . $array[$x] . " <br>";
	}

echo "<p> Here is the phrase encrypted: ";

	for($x = 0; $x <= $z; $x++)
	{
		if($array[$x] == "a"){echo "z";}
			elseif ($array[$x] == "b"){echo "y";}
			elseif ($array[$x] == "c"){echo "x";}
			elseif ($array[$x] == "d"){echo "w";}
			elseif ($array[$x] == "e"){echo "v";}
			elseif ($array[$x] == "f"){echo "u";}
			elseif ($array[$x] == "g"){echo "t";}
			elseif ($array[$x] == "h"){echo "s";}
			elseif ($array[$x] == "i"){echo "r";}
			elseif ($array[$x] == "j"){echo "q";}
			elseif ($array[$x] == "k"){echo "p";}
			elseif ($array[$x] == "l"){echo "o";}
			elseif ($array[$x] == "m"){echo "n";}
			elseif ($array[$x] == "n"){echo "m";}
			elseif ($array[$x] == "o"){echo "l";}
			elseif ($array[$x] == "p"){echo "k";}
			elseif ($array[$x] == "q"){echo "j";}
			elseif ($array[$x] == "r"){echo "i";}
			elseif ($array[$x] == "s"){echo "h";}
			elseif ($array[$x] == "t"){echo "g";}
			elseif ($array[$x] == "u"){echo "f";}
			elseif ($array[$x] == "v"){echo "e";}
			elseif ($array[$x] == "w"){echo "d";}
			elseif ($array[$x] == "x"){echo "c";}
			elseif ($array[$x] == "y"){echo "b";}
			elseif ($array[$x] == "z"){echo "a";}
			else {echo $array[$x];}
	}
}







function AtbashDeCipher($input){

$text = $input;
$array = str_split($text);
$z = count($array);	//NUMBER OF CHARACTERS SPLIT IN ARRAY

	for($x = 0; $x <= $z; $x++)
	{
		echo $x ." - " . $array[$x] . " <br>";
	}

echo "<p> Here is the phrase decrypted: ";

	for($x = 0; $x <= $z; $x++)
	{
		if($array[$x] == "z"){echo "a";}
			elseif ($array[$x] == "y"){echo "b";}
			elseif ($array[$x] == "x"){echo "c";}
			elseif ($array[$x] == "w"){echo "d";}
			elseif ($array[$x] == "v"){echo "e";}
			elseif ($array[$x] == "u"){echo "f";}
			elseif ($array[$x] == "t"){echo "g";}
			elseif ($array[$x] == "s"){echo "h";}
			elseif ($array[$x] == "r"){echo "i";}
			elseif ($array[$x] == "q"){echo "j";}
			elseif ($array[$x] == "p"){echo "k";}
			elseif ($array[$x] == "o"){echo "l";}
			elseif ($array[$x] == "n"){echo "m";}
			elseif ($array[$x] == "m"){echo "n";}
			elseif ($array[$x] == "l"){echo "o";}
			elseif ($array[$x] == "k"){echo "p";}
			elseif ($array[$x] == "j"){echo "q";}
			elseif ($array[$x] == "i"){echo "r";}
			elseif ($array[$x] == "h"){echo "s";}
			elseif ($array[$x] == "g"){echo "t";}
			elseif ($array[$x] == "f"){echo "u";}
			elseif ($array[$x] == "e"){echo "v";}
			elseif ($array[$x] == "d"){echo "w";}
			elseif ($array[$x] == "c"){echo "x";}
			elseif ($array[$x] == "b"){echo "y";}
			elseif ($array[$x] == "a"){echo "z";}
			else {echo $array[$x];}
	}
}





?>

<html><head></head><body>

This is my $z output: <br> <?php  AtbashCipher('we love our ist capstone project'); ?> <br>
This is my $z output: <br> <?php  AtbashDeCipher('fhv gsv ulixv ofpv'); ?> <br>


</body></html>
