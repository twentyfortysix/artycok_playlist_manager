<?php
/*
Template name: helper
 */ 
//
// gets the data from the angular playlist manager
// do some trisk with the data
// save them to the user valut
// 
if(is_user_logged_in()){
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$data = file_get_contents("php://input");
	//~ convert theretrieved data to nice JSON format
	$objData = json_decode($data);

	$referer = $_SERVER["HTTP_REFERER"];
	$nonce = $objData->data->nonce;
	$playlist = $objData->data->playlist;
	$playlist_switch = $objData->data->playlist_switch;

	$the_correct_referer = get_permalink(2);

	// later check the referer and nonce
	if (wp_verify_nonce($nonce, 'artycok-playlist-nonce') && $referer == $the_correct_referer){
		// save the playlist to user meta
		// update_user_meta( $user_id, $meta_key, $meta_value, $prev_value )
		// update_usermeta( $user_id, 'playlist', '' );
		update_usermeta( $user_id, 'playlist', $playlist, $playlist );
		update_usermeta( $user_id, 'playlist_switch', $playlist_switch );

		// return the note back to user
		echo '<div class="alert alert-success fadeOut">
			saved: '. date("d.m.Y H:i:s") .'
		</div>';
		// echo '<pre>';
		// var_dump($playlist);
		// echo '</pre>';
		// var_dump(get_the_author_meta( "playlist", $user_id ));
	} // END security test
	else{
		// cover direct page loading
		die('..hackity hack, you bad boy!'); 
	}
}