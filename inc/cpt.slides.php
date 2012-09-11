<?php
/**
 * Custom Post Type: Slides
 */

add_action( 'init', 'gs_slides_cpt');
if ( !function_exists('gs_slides_cpt') ) {

	/** 
	 * Registers a custom post type & custom taxonomies.
	 *
	 * @uses register_post_type()
	 * @uses register_taxonmy()
	 * @uses register_taxonmy_for_object_type()
	 *
	 */
	function gs_slides_cpt() { 

		/** 
		 * Sets labels for the Post Type
		 */
		$cpt_slug = 'slide';
		$singular = 'Slide';
		$plural = 'Slides';

		/** 
		 * Sets supported features
		 */
		$supported_features = array('title', 
									'editor', 
									'thumbnail', 
									'revisions'
									);

		/** 
		 * Registers the post type
		 * @link http://codex.wordpress.org/Function_Reference/register_post_type
		 */
		register_post_type( $cpt_slug,
			array(
				'labels' => array(
					'name' => __($plural, 'post type general name'),
					'singular_name' => __($singular, 'post type singular name'),
					'add_new' => __('Add New '. $singular, 'custom post type item'), 
					'add_new_item' => __('Add New '. $singular),
					'edit' => __( 'Edit' ), 
					'edit_item' => __('Edit '. $singular),
					'new_item' => __('New '. $singular),
					'view_item' => __('View '. $singular),
					'search_items' => __('Search '. $plural),
					'not_found' =>  __('Nothing found in the Database.'),
					'not_found_in_trash' => __('Nothing found in Trash'),
					'parent_item_colon' => ''
					),
				'description' => __( $plural .' custom post type.'),
				'public' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'show_ui' => true,
				'query_var' => true,
				'menu_position' => 8, 
				'menu_icon' => get_stylesheet_directory_uri() . '/img/admin/cpt-slide.png',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'has_archive' => true,
				'supports' => $supported_features
		 	)
		); 
	    
	} 
}