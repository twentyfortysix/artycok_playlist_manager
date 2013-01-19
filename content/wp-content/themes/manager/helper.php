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
	$force_tv_restart = $objData->data->force_tv_restart;
	$box_IP = $objData->data->box_IP;

	$the_correct_referer = get_permalink(2);

	// later check the referer and nonce
	if (wp_verify_nonce($nonce, 'artycok-playlist-nonce') && $referer == $the_correct_referer){
		// save the playlist to user meta
		// update_user_meta( $user_id, $meta_key, $meta_value, $prev_value )
		// update_usermeta( $user_id, 'playlist', '' );
		update_usermeta( $user_id, 'playlist', $playlist, $playlist );
		update_usermeta( $user_id, 'playlist_switch', $playlist_switch );
		update_usermeta( $user_id, 'box_IP', $box_IP );

		$e_message = '';
		// 
		// RESTART THE REMOTE TV BOX
		// 
		if($force_tv_restart == 'true'){

			// get the password defined in admin DB
			$password = get_the_author_meta( "remote_password", 1);
			// execute the Shell command on remote host
			// restart browser
			if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");
				 // log in at server1.example.com on port 22
			if(!($con = ssh2_connect($box_IP, 22))){
				$e_message .= "fail: unable to conncet the TV BOX\n";
			} else {
				     // try to authenticate with username root, password secretpassword
				     // if(!ssh2_auth_password($con, "root", "secretpassword")) {
				if(!ssh2_auth_password($con, "tv", $password)) {
					$e_message .= "fail: unable to authenticate\n";
				} else {				         // execute a command
					if (!($stream = ssh2_exec($con, "killall chrome && sleep 5 && DISPLAY=:0 google-chrome --kiosk http://manager.artycok.tv/?author=1 2> /dev/null  && exit" ))) {
						$e_message .= "fail: unable to execute command\n";
					} else {
				             // collect returning data from command
						stream_set_blocking($stream, false);
						$data = "";
						while ($buf = fread($stream,4096)) {
							$data .= $buf;
						}
						fclose($stream);
						$e_message .= ':) ';
					}
				}
			}
		}

		// return the note back to user
		echo '<div class="alert alert-success fadeOut">
		saved: '. date("d.m.Y H:i:s") . $e_message .'
		</div>';

	} // END security test
	else{
		// cover direct page loading
		die('..hackity hack, you bad boy!'); 
	}
}