<?php

# Find fractions that are good approximations of the value of PI
# Fractions that are simpler to remember can be found by increasing the $max_error value and decreasing the $ceiling value

$start = microtime(true);

$ceiling = 15000000;//max numerator to go through
$max_error = 0.000000000001;//don't save the value if error is greater that this; smaller value = faster execution time
$precision = 14;//use 14 digits after a floating point when calculating error
$results = 10;//show best 10 results
$pit_stop_location = 100000;//will optimize every this amomunt of numerators
$hard_stop_after = 2.95;//need to finish before the execution limit of 3sec by the compiler

$array = [];
//$pi = M_PI;//need to use more precise pi than 3.1415926535898 xD
$pi = 3.1415926535897932384626433832795028841971693993751;
$min_int = $pi-$max_error;
$max_int = $pi+$max_error;

echo "Real pi: ".$pi."\n\n";

for($i=0;$i<$ceiling;$i++){
    
    $min = floor($i/$max_int);
    $max = ceil($i/$min_int);
    
    if($min==0)
        continue;
        
    if($i%$pit_stop_location==0){
        
        //leave only top X results
        ksort($array);
        $array = array_slice($array,0,$results,true);
        
        //stop if close to the execution limit
        if(microtime(true)-$start>$hard_stop_after)
            break;
    }
    
    for($ii=$min;$ii<$max;$ii++){
            
        $error = abs($i/$ii-$pi);
        $key = round($error*pow(10,$precision),$precision);
        
        if($error<$max_error && (!array_key_exists(intval($key),$array) || $array[$key][0]>$i))
            $array[$key] = [$i,$ii,$i/$ii,$error];
            
    }
        
    
}

ksort($array);//sort array by keys

$i=0;
foreach($array as $node){

    echo $node[0].' \\ '.$node[1].' = '.$node[2].' ( ';
    printf('%.20F',$node[3]);
    echo " )\n";

    if(++$i>$results-1)
        break;

}

$end = microtime(true);
echo "\nTime elapsed: ".($end-$start);