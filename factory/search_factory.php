<?php
	function include_search_scripts(){
		//loading the main script for the custom search function to work
		wp_register_script( 'nano-scroller-script', get_template_directory_uri().'/js/nanoscroller.min.js', array('jquery') );
		wp_enqueue_script( 'nano-scroller-script' );

		//loading the handlebars script for the custom search function to work
		wp_register_script( 'handlebars-script', get_template_directory_uri().'/js/handlebars.min.js', array('jquery') );
		wp_enqueue_script( 'handlebars-script' );

		//loading the main script for the custom search function to work
		wp_register_script( 'custom-search-script', get_template_directory_uri().'/js/scripts.js', array('jquery') );
		wp_enqueue_script( 'custom-search-script' );

		$ajax_data = array( 'ajaxurl' => admin_url( 'admin-ajax.php'), 'tplurl' => get_template_directory_uri().'/factory/hb-tpls/' );
		wp_localize_script( 'custom-search-script', 'SEARCH_AJAX', $ajax_data );
	}	


	function include_search_styles(){
		//loading the main stylesheet for the custom search page
		wp_register_style("custom-search-styles", get_template_directory_uri()."/styles/search-style.css");
		wp_enqueue_style("custom-search-styles"); 

		//loading the fonts stylesheet for the custom search page
		wp_register_style("font-awesome-styles", get_template_directory_uri()."/styles/font-awesome.css");
		wp_enqueue_style("font-awesome-styles"); 
	}

	add_action( 'wp_enqueue_scripts', 'include_search_scripts' );
	add_action( 'wp_enqueue_scripts', 'include_search_styles');

	add_action( 'wp_ajax_save_custom_search', 'save_custom_search' );
	add_action( 'wp_ajax_nopriv_save_custom_search', 'save_custom_search' );

	function save_custom_search(){
		extract($_POST);
		global $wpdb;

		if( !isset($search_query) || empty($search_query) )
			return false;
		if( !isset($email) || empty($email) )
			return false;
		if ( !isset($nome) || empty($nome) ) 
			return false;
		if ( !isset($cognome) || empty($cognome) ) 
			return false;

		$postarr = array(
			'post_title' => 'Custom Search query by - '.$cognome,
			'post_type' => 'custom_search',
			'post_status' => 'publish'
		);

		$post_id = wp_insert_post( $postarr, $wp_error = false );
		$search_query = serialize($search_query);

		if( $post_id ){
			add_post_meta( $post_id, 'custom_search_query', $search_query );
			update_field( 'user_meta_nome', $nome, $post_id );
			update_field( 'user_meta_cognome', $cognome, $post_id );
			update_field( 'user_meta_email', $email, $post_id );
			update_field( 'user_meta_telefono', $telefono, $post_id );

			wp_send_json(array( 
				'posted' => $post_id,
				'query' => serialize($search_query)
			));
		}
		die();
	}

	//custom post type for the search queries
	add_action( 'init', 'create_custom_search_post_type' );

	function create_custom_search_post_type() {
		$labels = array(
			'name'                => _x( 'Custom Searches', 'Post Type General Name', 'text_domain' ),
			'singular_name'       => _x( 'Custom Search', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'           => __( 'Custom Searches', 'text_domain' ),
			'parent_item_colon'   => __( 'Parent Custom Searchest:', 'text_domain' ),
			'all_items'           => __( 'All Custom Searches', 'text_domain' ),
			'view_item'           => __( 'View Custom Search', 'text_domain' ),
			'add_new_item'        => __( 'Add New Search', 'text_domain' ),
			'add_new'             => __( 'New Search', 'text_domain' ),
			'edit_item'           => __( 'Edit Custom Search', 'text_domain' ),
			'update_item'         => __( 'Update Custom Search', 'text_domain' ),
			'search_items'        => __( 'Search Custom Searches', 'text_domain' ),
			'not_found'           => __( 'No Custom Searches found', 'text_domain' ),
			'not_found_in_trash'  => __( 'No Custom Searches found in Trash', 'text_domain' ),
		);

		$args = array(
			'label'               => __( 'custom_search', 'text_domain' ),
			'description'         => __( 'Custom searches ', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		register_post_type( 'custom_search', $args );
	}

	//custom metabox to display the custom search fields.
	add_action( 'add_meta_boxes', 'query_details_metabox' );

	function query_details_metabox() {
	    add_meta_box( 
	    	'query_details', 
	    	'Query consistis of the following data', 
	    	'print_custom_search_details', 
	    	'custom_search' 
	    );
	}

	function print_custom_search_details($post){
		$search_query = get_field('custom_search_query', $post->ID);

		extract($search_query);
		ob_start();
		include "query_details_tpl.php";
		$tpl = ob_get_contents();
		ob_end_clean();

		echo $tpl;
	}

	include 'skeleton_factory.php';




	add_action( 'wp_ajax_show_latest_custom_search', 'show_latest_custom_search' );
	add_action( 'wp_ajax_nopriv_show_latest_custom_search', 'show_latest_custom_search' );
	
	function show_latest_custom_search(){
		$searches = new WP_Query(array(
			'post_type' => 'custom_search',
			'offset'  => $_POST['from']
		));

		$ret = array();

		if( $searches->have_posts() ): 
			while( $searches->have_posts() ):
				$searches->the_post();
				$data = array(
					'filtrousato' => serialize(get_field( 'custom_search_query' )),
					'status' => 0,
					'to' => 1,
					'origin' => 'mailtogo'
				);
				array_push($ret, $data);
			endwhile;
		endif;

		wp_send_json( $ret );
		die();
	}