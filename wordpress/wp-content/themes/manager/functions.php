<?php 
register_sidebar( array(

		'name' => __( 'Login', 'twentyeleven' ),
		'id' => '001',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'User', 'twentyeleven' ),
		'id' => '002',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
function f_2046_add_scripts() {
	wp_deregister_script( 'jquery' );
	
	wp_register_script ( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
	wp_register_script ( 'jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js', array('jquery'));
	wp_register_script ( 'angular-min', get_bloginfo('template_directory') .'/js/angular.min.js',array('jquery'));
	wp_register_script ( 'angular-min-ui', get_bloginfo('template_directory') .'/js/angular-ui.min.js',array('angular-min'));
	wp_register_script ( 'manager-controler', get_bloginfo('template_directory') .'/js/controler.js',array('angular-min-ui'));	
	// wp_register_script ( 'bootstrap-js', get_bloginfo('template_directory') .'/bootstrap/js/bootstrap.min.js',array('jquery'));	
	wp_register_style ( 'bootstrap-css', get_bloginfo('template_directory') .'/bootstrap/css/bootstrap.css');
	wp_register_style ( 'my-css', get_bloginfo('template_directory') .'/style.css', array('bootstrap-css'));
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui' );
	// wp_enqueue_script( 'bootstrap-js' );
	wp_enqueue_script( 'angular-min' );
	wp_enqueue_script( 'angular-min-ui' );
	wp_enqueue_script( 'manager-controler' );
	wp_enqueue_style( 'bootstrap-css' );
	wp_enqueue_style( 'my-css' );
	if(is_author()){

		wp_register_script ( 'jwplayer', get_bloginfo('template_directory') .'/jwplayer/jwplayer.js');	
		wp_enqueue_script( 'jwplayer' );
	}
	
}
add_action('wp_enqueue_scripts', 'f_2046_add_scripts');


/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );

function yoast_hide_admin_bar_settings() {
?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php
}

function yoast_disable_admin_bar() {
    add_filter( 'show_admin_bar', '__return_false' );
    add_action( 'admin_print_scripts-profile.php', 
         'yoast_hide_admin_bar_settings' );
}
add_action( 'init', 'yoast_disable_admin_bar' , 9 );

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
	$output = str_replace("./", "", $matches);
	return $output;
}
// remove unwanted string from file path
function remove_spaces($matches){
	$output = str_replace(" ", "", $matches);
	return $output;
}
// remove unwanted string from file path
function remove_p($matches){
	$output = str_replace("p", "", $matches);
	return $output;
}