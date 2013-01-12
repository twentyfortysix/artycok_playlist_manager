<?php 
//
// Well this page get the user saved playlist (link to videos)
// then prepares the data for the player and shows the player to the publick
// 

get_header();

global $wp_query;
$curauth = $wp_query->get_queried_object();

$playlist = $curauth->playlist;
$playlist_switch = $curauth->playlist_switch;

$jw_playlist = array();
// streame ris in the global var
//$streamer = 'rtmp://server5.streaming.cesnet.cz/vod';
global $streamer;
global $available_qualities;

$length = sizeOf($playlist);

// open the playlist string
$jwplayer_playlist = "playlist: [\n";
// rebuild the playlist for player
$i = 0;
foreach ($playlist as $key => $value) {
	$tmp_video_quality = 0;
	$tmp_link = '';
	$jwplayer_playlist .= '{sources: [{' ;
		foreach ($value as $k => $v) {
			// take the best video quality available
			// and push it to the player playlist
			if( in_array($k, $available_qualities) && $tmp_video_quality < remove_p($k)) {
				$tmp_link = 'file: "'. $streamer .'/_definst_/others/avu/artycok/'. $v.'"';
				$tmp_video_quality = remove_p($k);
			}
		}
		$jwplayer_playlist .= $tmp_link;
		$jwplayer_playlist .= '}' ;
	// just do the propriate javascript array closing
	if($i != $length-1){
		$jwplayer_playlist .= "]},\n";	
	}else{
		$jwplayer_playlist .= ']';
	}
	$i++;
}
// close the playlist string
$jwplayer_playlist .= '}]';
?>

<div id="player_7526"></div>
<script type='text/javascript'>
jQuery(document).ready(function($) {
	var viewportWidth = $(window).width();
	var viewportHeight = $(window).height();

	jwplayer('player_7526').setup({
		<?php echo $jwplayer_playlist; ?>,
		autostart: "true"
		// playlist: [
		// 	{ sources: [
	 	//        { 
	 	//        	file: "rtmp://server5.streaming.cesnet.cz/vod/_definst_/others/avu/artycok/2012/12/2012-12-tallinn-kumu_show-exhibition/2012-12-tallinn-kumu_show-exhibition-360p.mp4" 
	 	//        }
		//     ]},
		//     { sources: [
		//         {
		//         	file: "rtmp://server5.streaming.cesnet.cz/vod/_definst_/others/avu/artycok/2013/01/2013-01-riga-rasa_jansone-everyday_masculinity/2013-01-riga-rasa_jansone-everyday_masculinity-576p.mp4" 
		//         }
		//     ]}
		//  ]
    	// width: viewportWidth,
    	// height: viewportHeight,
    	// width: 600,
    	// height: 400
    });	
});


</script>

<?php get_footer();

