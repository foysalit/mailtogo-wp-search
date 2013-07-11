<?php

add_action( 'wp_ajax_get_categories_skeleton', 'get_categories_skeleton' );
add_action( 'wp_ajax_nopriv_get_categories_skeleton', 'get_categories_skeleton' );

function get_categories_skeleton(){
	extract($_POST);
	global $wpdb;

	$categories = $wpdb->get_results("SELECT * FROM categories");

	wp_send_json(array( 
		'categories' => $categories
	));

	die();
}


add_action( 'wp_ajax_get_subcategories_skeleton', 'get_subcategories_skeleton' );
add_action( 'wp_ajax_nopriv_get_subcategories_skeleton', 'get_subcategories_skeleton' );

function get_subcategories_skeleton(){
	extract($_POST);
	global $wpdb;

	$sql_query = "SELECT * FROM subcategories";

	if( isset( $params['cats'] ) && is_array( $params['cats'] ) ){
		$cats = implode(', ', array_values($params['cats']) );
		$sql_query .= " WHERE categories_id IN (". $cats .")";
		//echo $sql_query;
	}

	$subcategories = $wpdb->get_results($sql_query);

	wp_send_json(array( 
		'subcategories' => $subcategories 
	));

	die();
}


add_action( 'wp_ajax_get_regions_skeleton', 'get_regions_skeleton' );
add_action( 'wp_ajax_nopriv_get_regions_skeleton', 'get_regions_skeleton' );

function get_regions_skeleton(){
	extract($_POST);
	global $wpdb;

	$sql_query = "SELECT * FROM regions";

	$regions = $wpdb->get_results($sql_query);

	wp_send_json(array( 
		'regions' => $regions 
	));

	die();
}


add_action( 'wp_ajax_get_zones_skeleton', 'get_zones_skeleton' );
add_action( 'wp_ajax_nopriv_get_zones_skeleton', 'get_zones_skeleton' );

function get_zones_skeleton(){
	extract($_POST);
	global $wpdb;

	$sql_query = "SELECT * FROM zones";

	$zones = $wpdb->get_results($sql_query);

	wp_send_json(array( 
		'zones' => $zones 
	));

	die();
}

