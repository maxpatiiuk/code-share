<?php

//config
$numerator = '-3x^3-4x^2+10x-7';//V1
$denominator = 'x-2';
/*$numerator = '3x^2-4x+7'; //V2
$denominator = 'x-1';*/
$quoitent = '';
$reminder = '';
define('_USE_HTML_',false);


//styles
if(_USE_HTML_)
    echo '<pre style="font-family:Consolas,monospace;">';


//removing bad characters
$numerator = preg_replace('/[^x^+\-\d]/','',$numerator);
$denominator = preg_replace('/[^x^+\-\d]/','',$denominator);
	

//calculating paddings
$numerator_length = strlen($numerator);
$numerator_prepend = str_repeat(' ',$numerator_length);
$numerator_line = str_repeat('_',$numerator_length);

$denominator_length = strlen($denominator);
$denominator_prepend = str_repeat(' ',$denominator_length);


//getting values into array
function non_empty_string($el){
	return strlen($el)!=0;
}

function custom_array_sort($a,$b){
	if($a[1]>$b[1])
		return -1;
	else
		return 1;
}

function extract_values($numerator){
	preg_match_all('/[+\-]?[\dx^]*/',$numerator,$numerator_values_raw);
	$numerator_values_raw = $numerator_values_raw[0];
	$numerator_values_raw = array_filter($numerator_values_raw,'non_empty_string');
	$numerator_values = [];
	$numerator_values_length = count($numerator_values_raw);
	
	for($i=0;$i<$numerator_values_length;$i++){
		$number_part = preg_replace('/x(\^\d*)?/','',$numerator_values_raw[$i]);
		$number_part = str_replace('+','',$number_part);
		if($number_part == '')
			$number_part = 1;

		preg_match('/x\^?\d*/',$numerator_values_raw[$i],$x_part);
		if(count($x_part)==1){
			$x_part = $x_part[0];
			if($x_part == 'x')
				$x_part = 1;
			else
				$x_part = substr($x_part,2);
		}
		else
			$x_part = 0;
		$numerator_values[] = [$number_part,$x_part];
	}

	usort($numerator_values,'custom_array_sort');

	$offset = 0;
	for($i=0;$i<=$numerator_values[0][1];$i++){
		if($numerator_values[0][1] - ($i + $offset) != $numerator_values[$i + $offset][1]){
			array_splice($numerator_values,$i,0,[[1,$numerator_values[0][1] - ($i + $offset)]]);
			$offset--;
		}
	}
	
	return [$numerator_values,$numerator_values_length];
}

$numerator_array_temp = extract_values($numerator);
$denominator_array_temp = extract_values($denominator);
//var_dump($denominator_array_temp);
$numerator_values = $numerator_array_temp[0];
$numerator_values_length = $numerator_array_temp[1];
$denominator_values = $denominator_array_temp[0];
$denominator_values_length = $denominator_array_temp[1];

if($numerator_values_length == 0 || $denominator_values_length == 0 || $numerator_values[0][1] < $denominator_values[0][1])
	exit();


//doing calculations
$calculations = [];
$ii=0;
while($numerator_values_length > 1){
	//var_dump($numerator_values);
	$ii++;
	if($ii>10)
		break;
	$calculations_n = $numerator_values[0][0] / $denominator_values[0][0];
	$calculations_x = $numerator_values_length - 2;
	$calculations[] = [$calculations_n,$calculations_x];
	//var_dump($calculations_n,$calculations_x);

	//var_dump($numerator_values);
	for($i=0;$i<$denominator_values_length;$i++){
		$numerator_values[$i][0] -= $calculations_n * $denominator_values[$i][0];
		//var_dump($calculations_n * $denominator_values[$i][0]);
		if($numerator_values[$i][0] == 0)
			$numerator_values[$i][1] = 0;
		//$numerator_values[$i][1] -= $calculations_x + $denominator_values[$i][1];
	}
	//var_dump($numerator_values);

	if($numerator_values[0] == [0,0])
		$numerator_values = array_slice($numerator_values,1);

	$numerator_values_length = count($numerator_values);
}

$reminder = $numerator_values[0][0];

foreach($calculations as $val){
	if($val[0]>0 && $quoitent != '')
		$quoitent .= '+';
	$quoitent .= $val[0];
	if($val[1]==1)
	 $quoitent .= 'x';
	else if($val[1]>0)
	 $quoitent .= 'x^'.$val[1];
}


//showing calculations
if(_USE_HTML_){
    echo $denominator_prepend.' '.$quoitent.'<br>';
    echo $denominator_prepend.$numerator_line.'<br>';
    echo $denominator.')'.$numerator.'<br>';
}
else {
    echo $denominator_prepend.' '.$quoitent."\n";
    echo $denominator_prepend.$numerator_line."\n";
    echo $denominator.')'.$numerator."\n";
}


//showing results
if(_USE_HTML_){
    echo '<br>Numerator: '.$numerator;
    echo '<br>Denominator: '.$denominator;
    echo '<br>Quoitent: '.$quoitent;
    echo '<br>Reminder: '.$reminder;
    echo '</pre>';
}
else {
    echo "\nNumerator: ".$numerator;
    echo "\nDenominator: ".$denominator;
    echo "\nQuoitent: ".$quoitent;
    echo "\nReminder: ".$reminder;
}