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
	
}
add_action('wp_enqueue_scripts', 'f_2046_add_scripts');


