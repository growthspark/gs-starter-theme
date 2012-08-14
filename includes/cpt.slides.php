<?php
/**************************************************************

:: Slides Custom Post Type

***************************************************************/

// Create function for the custom type.  Function name must be unique.
function gs_slides_cpt() { 

	/* ----------------------------------------------------------
	Set Post Type Name
	-------------------------------------------------------------*/
	$cpt_slug = 'slide';
	$singular = 'Slide';
	$plural = 'Slides';

	/* ----------------------------------------------------------
	Set Supported Features
	-------------------------------------------------------------*/
	$supported_features = array('title', 
								'editor', 
								'thumbnail', 
								'revisions', 
								);

	/* ----------------------------------------------------------
	Register the Post Type
	-------------------------------------------------------------*/
	register_post_type( $cpt_slug, // (http://codex.wordpress.org/Function_Reference/register_post_type) 
		array('labels' => array(
			'name' => __('Slides', 'post type general name'), // This is the Title of the Group 
			'singular_name' => __($singular, 'post type singular name'), // This is the individual type 
			'add_new' => __('Add New ' . $singular, 'custom post type item'), // The add new menu item 
			'add_new_item' => __('Add New ' . $singular), // Add New Display Title 
			'edit' => __( 'Edit' ), // Edit Dialog 
			'edit_item' => __('Edit '. $plural), // Edit Display Title 
			'new_item' => __('New '. $singular), // New Display Title 
			'view_item' => __('View '. $singular), // View Display Title 
			'search_items' => __('Search '. $plural), // Search Custom Type Title  
			'not_found' =>  __('Nothing found in the Database.'), // This displays if there are no entries yet  
			'not_found_in_trash' => __('Nothing found in Trash'), // This displays if there is nothing in the trash 
			'parent_item_colon' => ''
			), // end of arrays 
			'description' => __( $plural .' custom post type.'), // Custom Type Description 
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 9, // this is what order you want it to appear in on the left hand side menu  
			'menu_icon' => get_template_directory_uri() . '/img/admin/cpt-slide.png', // the icon for the custom post type menu 
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			// the next one is important, it tells what's enabled in the post editor 
			'supports' => $supported_features
	 	) // end of options 
	); // end of register post type
	
	// Add your post categories to your custom post type
	//register_taxonomy_for_object_type('category', $cpt_slug);
	// Add your post tags to your custom post type
	//register_taxonomy_for_object_type('post_tag', $cpt_slug);
	
} 

	// Add the function to the Wordpress init
	add_action( 'init', 'gs_slides_cpt');
	
	
	/* ----------------------------------------------------------
	Set up Hierarchical Taxonomy (category)
	-------------------------------------------------------------*/
	/*
    register_taxonomy( 'custom_cat', 
    	array($cpt_slug), // if you change the name of register_post_type( 'custom_type', then you have to change this 
    	array('hierarchical' => true,     // if this is true it acts like categories             
    		'labels' => array(
    			'name' => __( 'Custom Categories' ), // name of the custom taxonomy 
    			'singular_name' => __( 'Custom Category' ), // single taxonomy name 
    			'search_items' =>  __( 'Search Custom Categories' ), // search title for taxomony 
    			'all_items' => __( 'All Custom Categories' ), // all title for taxonomies 
    			'parent_item' => __( 'Parent Custom Category' ), // parent title for taxonomy 
    			'parent_item_colon' => __( 'Parent Custom Category:' ), // parent taxonomy title 
    			'edit_item' => __( 'Edit Custom Category' ), // edit custom taxonomy title 
    			'update_item' => __( 'Update Custom Category' ),// update title for taxonomy 
    			'add_new_item' => __( 'Add New Custom Category' ), // add new title for taxonomy 
    			'new_item_name' => __( 'New Custom Category Name' ) // name title for taxonomy 
    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); */
    
	/* ----------------------------------------------------------
	Set up Non-Hierarchical Taxonomy (tags)
	-------------------------------------------------------------*/
    /*register_taxonomy( 'custom_tag', 
    	array('custom_type'), // if you change the name of register_post_type( 'custom_type', then you have to change this 
    	array('hierarchical' => false,    // if this is false, it acts like tags                 
    		'labels' => array(
    			'name' => __( 'Custom Tags' ), // name of the custom taxonomy 
    			'singular_name' => __( 'Custom Tag' ), // single taxonomy name 
    			'search_items' =>  __( 'Search Custom Tags' ), // search title for taxomony 
    			'all_items' => __( 'All Custom Tags' ), // all title for taxonomies 
    			'parent_item' => __( 'Parent Custom Tag' ), // parent title for taxonomy 
    			'parent_item_colon' => __( 'Parent Custom Tag:' ), // parent taxonomy title 
    			'edit_item' => __( 'Edit Custom Tag' ), // edit custom taxonomy title
    			'update_item' => __( 'Update Custom Tag' ),// update title for taxonomy 
    			'add_new_item' => __( 'Add New Custom Tag' ), // add new title for taxonomy 
    			'new_item_name' => __( 'New Custom Tag Name' ) // name title for taxonomy 
    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); */
