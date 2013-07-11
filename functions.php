<?php

add_theme_support('nav-menus');
add_theme_support('post-thumbnails');

if ( function_exists('register_nav_menus') ) {
	register_nav_menus(array(
		'header_menu' => 'menu in header',
	));
}


//including js and css files in the header for the theme
function include_my_js(){
	//including jquery script explicitly
	wp_enqueue_script("jquery"); 
	
	//validation plugin for forms
	wp_register_script("mediaquery-script", get_template_directory_uri()."/js/mediaqueries.js");
	wp_enqueue_script("mediaquery-script"); 
	
	//validation plugin for forms
	wp_register_script("validation-script", get_template_directory_uri()."/js/validate.min.js");
	wp_enqueue_script("validation-script"); 
	
	//easing plugin
	wp_register_script("easing-script", get_template_directory_uri()."/js/easing.js");
	wp_enqueue_script("easing-script"); 
	
	//cycle plugin for sliders
	wp_register_script("cycle-script", get_template_directory_uri()."/js/cycle.js");
	wp_enqueue_script("cycle-script");  
	
	//javascript codes for website
	wp_register_script("main-script", get_template_directory_uri()."/js/main.js");
	wp_enqueue_script("main-script"); 
	
	//only incule javascript codes for browsers less than ie 8
	if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT'])){
		wp_register_script("iehack-script", get_template_directory_uri()."/js/ie-hacks.js");
		wp_enqueue_script("iehack-script"); 
	}else{
		// if IE>8 
	}
}
function include_my_css(){
	//wp_enqueue_style('thickbox');
}
	

function include_my_admin_css(){
	//wp_register_style("admin-styling", get_template_directory_uri()."/css/admin_panel_style.css");
	//wp_enqueue_style("admin-styling"); 
	
}
function include_my_admin_js(){
	//wp_register_script("admin-javascript", get_template_directory_uri()."/js/admin_javascript.js");
	//wp_enqueue_script("admin-javascript"); 
	
}

add_action( 'wp_enqueue_scripts', 'include_my_js');
//add_action( 'wp_enqueue_scripts', 'include_my_css');

//add_action( 'admin_print_styles-post-new.php', 'include_my_admin_css');
//add_action( 'admin_print_styles-post.php', 'include_my_admin_css');
//add_action( 'admin_print_styles-post-new.php', 'include_my_admin_js');
//add_action( 'admin_print_styles-post.php', 'include_my_admin_js');

/*including js and css files for theme ends*/


require_once("inc/shortcodes.php");
?>