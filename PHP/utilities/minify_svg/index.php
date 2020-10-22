<?php
function min_svg($svg){
	
	$svg = trim(strip_tags($svg,'<svg><path>'));
	$svg = preg_replace_callback('/#[\da-f]{6}/mi', function($m){
		return strtolower($m[0][0].$m[0][1].$m[0][3].$m[0][5]);
	}, $svg);
	
	$a = ['/\.\d+/','/[\n\r]/','/< svg.*<svg/','/\b([a-z:]+)\b(?<!viewBox|d|style)=".*?"/mi','/id=".*?"/mi','/\s{1,}/','/> </','/" >/','/ "/','/;"/','/ \//'];
	$b = ['','','<svg','','',' ','><','">','"','"','/'];
	
	$svg = preg_replace($a, $b, $svg);
	
	$svg = preg_replace_callback('/\d [a-z]|[a-z] \d/mi', function($m){
		return $m[0][0].$m[0][2];
	}, $svg);
	
	$svg = preg_replace_callback('/<svg[^>]*style="[^>]*"/mi', function($m){
		return substr($m[0],0,strpos($m[0],' style')).substr(substr($m[0],strpos($m[0],'style')),strpos(substr($m[0],strpos($m[0],'style')+7),'"')+8);
	}, $svg);
	
	return trim($svg);
	
	
}

$svg='';
echo min_svg($svg);