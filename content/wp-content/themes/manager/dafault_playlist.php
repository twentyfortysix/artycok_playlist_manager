<?php 
/*
Template name: default playlist
 */
if(is_user_logged_in()){
	$user_id = 2;
	$default_playlist = get_the_author_meta( "playlist", $user_id );
	$file_in_json = json_encode($default_playlist);
	echo $file_in_json;
}