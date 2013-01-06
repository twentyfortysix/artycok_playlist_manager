<?php 
$input = array(
	array('a' => '350p'), 
	array('a' => '720p'),
	array('b' => '350p'),
	array('b' => '720p'),
	array('c' => '350p')
);
$output = array();
$tmp = array();
//  @key = name
//  @val = quality 
$i = 0;
foreach($input as $each){
	foreach($each as $key => $val){
		if(array_key_exists($key, $tmp)){
			$diff_quality = array($val => 'link');
			$result = array('name' => $key, $val => 'link');
			$merged = array_merge(end($output), $result);
			var_dump($merged);
			$output = array_replace($output, array($i-1 => $merged));
		 }else{
		 	$output[] = array('name' => $key, $val => 'link');
		 	$i++;
		 }
	}
	$tmp = $each;
}

echo '<pre>';
var_dump($output);
echo '</pre>';