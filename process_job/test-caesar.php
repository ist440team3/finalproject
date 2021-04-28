<?php

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

function Decipher($input, $key)
{
	return Encipher($input, 26 - $key);
}


?>

<html><head></head><body>

<p>
<?php $text = "these arent the droids you are looking for"; $cipherText = Encipher($text, 25); echo $cipherText; ?>
<p>
Here is it deciphered: <br>
<?php $plainText = Decipher($cipherText, 25); echo $plainText; ?>
<p>
<table border="1">
<tr><td>Shift</td><td>Original Text</td><td>Caesar Cipher Text</td></tr>
<tr><td>1</td><td>we love our ist capstone project</td><td>xf mpwf pvs jtu dbqtupof qspkfdu</td></tr>
<tr><td>2</td><td>we love our ist capstone project</td><td>yg nqxg qwt kuv ecruvqpg rtqlgev</td></tr>
<tr><td>3</td><td>we love our ist capstone project</td><td>zh oryh rxu lvw fdsvwrqh surmhfw</td></tr>
<tr><td>4</td><td>we love our ist capstone project</td><td>ai pszi syv mwx getwxsri tvsnigx</td></tr>
<tr><td>5</td><td>we love our ist capstone project</td><td>bj qtaj tzw nxy hfuxytsj uwtojhy</td></tr>
<tr><td>6</td><td>we love our ist capstone project</td><td>ck rubk uax oyz igvyzutk vxupkiz</td></tr>
<tr><td>7</td><td>do or do not there is no try</td><td>kv vy kv uva aolyl pz uv ayf</td></tr>
<tr><td>8</td><td>do or do not there is no try</td><td>lw wz lw vwb bpmzm qa vw bzg</td></tr>
<tr><td>9</td><td>do or do not there is no try</td><td>mx xa mx wxc cqnan rb wx cah</td></tr>
<tr><td>10</td><td>do or do not there is no try</td><td>ny yb ny xyd drobo sc xy dbi</td></tr>
<tr><td>11</td><td>do or do not there is no try</td><td>oz zc oz yze espcp td yz ecj</td></tr>
<tr><td>12</td><td>do or do not there is no try</td><td>pa ad pa zaf ftqdq ue za fdk</td></tr>
<tr><td>13</td><td>use the force luke</td><td>hfr gur sbepr yhxr</td></tr>
<tr><td>14</td><td>use the force luke</td><td>igs hvs tcfqs ziys</td></tr>
<tr><td>15</td><td>use the force luke</td><td>jht iwt udgrt ajzt</td></tr>
<tr><td>16</td><td>use the force luke</td><td>kiu jxu vehsu bkau</td></tr>
<tr><td>17</td><td>use the force luke</td><td>ljv kyv wfitv clbv</td></tr>
<tr><td>18</td><td>use the force luke</td><td>mkw lzw xgjuw dmcw</td></tr>
<tr><td>19</td><td>use the force luke</td><td>nlx max yhkvx endx</td></tr>
<tr><td>20</td><td>these arent the droids you are looking for</td><td>nbymy ulyhn nby xlicxm sio uly fiiecha zil</td></tr>
<tr><td>21</td><td>these arent the droids you are looking for</td><td>ocznz vmzio ocz ymjdyn tjp vmz gjjfdib ajm</td></tr>
<tr><td>22</td><td>these arent the droids you are looking for</td><td>pdaoa wnajp pda znkezo ukq wna hkkgejc bkn</td></tr>
<tr><td>23</td><td>these arent the droids you are looking for</td><td>qebpb xobkq qeb aolfap vlr xob illhfkd clo</td></tr>
<tr><td>24</td><td>these arent the droids you are looking for</td><td>rfcqc ypclr rfc bpmgbq wms ypc jmmigle dmp</td></tr>
<tr><td>25</td><td>these arent the droids you are looking for</td><td>sgdrd zqdms sgd cqnhcr xnt zqd knnjhmf enq</td></tr>



</table>
</body></html>


