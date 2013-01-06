<?php 

// $handle = fopen("list", "r");
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$file = file('list');

// clear "\n" 
function remove_enter($matches){
	$output = str_replace("\n", "", $matches);
	return $output;
}
// remove ".mp4"
function remove_sufix($matches){
	$output = str_replace(".mp4", "", $matches);
	return $output;
}
// remove qaulity from file(path) name such as" 360p etc.
function remove_quality($matches){
	$exploded = explode('-',$matches);
	// mydump($exploded);
	$output = str_replace(end($exploded), "", $matches);
	return $output;
}
//  get the quality out of the string
function get_quality($matches){
	$exploded = explode('-',$matches);
	// mydump(end($exploded));
	$output = end($exploded);
	return $output;
}
// remove unwanted dashes (bueatify the file name)
function remove_dashes($matches){
	$output = str_replace("-", " ", $matches);
	return $output;
}
// remove unwanted string from file path
function remove_current_path($matches){
	$output = str_replace("./", " ", $matches);
	return $output;
}


// loop through the file
// create JSON: file_name > file_path

$output = array();
$tmp = array();
//  needed value for traversing through the output array
$i = 0; 
// resort the natural ASC file sorting to DESC
krsort($file);

foreach($file as $each){
	// explode the file names to needed parts
	$exploded = explode('/', $each);
	// cclean the name part a bit
	$name = remove_quality(remove_sufix(remove_enter(end($exploded))));
	// get just the video quality
	$quality = remove_sufix(get_quality($each));
	// if the file is the same like the one before, but with different quality
	// add that quality to the previous entries
	
	$rand_order = rand(1,6);
	$tmp_rand = rand(0,6);
	if($tmp_rand == 1){
		$tmp_done = true;
	}else{
		$tmp_done = false;
	}

	if($name == $tmp){
		// $diff_quality = array($val => 'link');
		$result = array('name' => remove_dashes($name), remove_enter($quality) => $each, 'done' => $tmp_done, 'pos' => 0);
		$merged = array_merge(end($output), $result);
		$output = array_replace($output, array($i-1 => $merged));
	 }
	 //  add the file to the array
	 else{
	 	$output[] = array('name' => remove_dashes($name), remove_enter($quality) => $each, 'done' => $tmp_done, 'pos' => 0);
	 	$i++;
	 }
	 // add the file name to tmp, so we can can check new coming agains it
	$tmp = $name;
}

// decode to JSON
$file_in_json = json_encode($output);
// output the JSON
echo $file_in_json;

// a innocent helper for var_dump
function mydump($val){
	echo '<pre>';
	var_dump($val);
	echo '</pre>';
}