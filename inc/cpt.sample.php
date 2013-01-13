<?php
/**
 * Template file for creating Custom Post Types
 *
 * To use, copy this template into a new file and save as 
 * "cpt.[your-post-type].php"
 *
 * Replace all instances of gs_sample_cpt with a UNIQUE function name.
 *
 */

add_action( 'init', 'gs_sample_cpt');
if ( !function_exists('gs_sample_cpt') ) {

	/** 
	 * Registers a custom post type & custom taxonomies.
	 *
	 * @uses register_post_type()
	 * @uses register_taxonmy()
	 * @uses register_taxonmy_for_object_type()
	 *
	 */
	function gs_sample_cpt() { 

		/** 
		 * Sets labels for the Post Type
		 */
		$cpt_slug = 'custom-post';
		$singular = 'Custom Post';
		$plural = 'Custom Posts';

		/** 
		 * Sets supported features
		 */
		$supported_features = array('title', 
									'editor', 
									'author', 
									'thumbnail', 
									'excerpt', 
									'trackbacks', 
									'custom-fields', 
									'comments', 
									'revisions', 
									'sticky'
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
				//'menu_icon' => get_stylesheet_directory_uri() . '/img/admin/cpt-icon.png',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'has_archive' => true,
				'supports' => $supported_features
		 	)
		); 

		/** 
		 * Registers a hierarchical taxonomy (eg Categories)
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
		 */
		$cat_slug = 'custom_category';
		$cat_singular = 'Custom Category';
		$cat_plural = 'Custom Categories';

	    register_taxonomy( $cat_slug, 
	    	array($cpt_slug),
	    	array('hierarchical' => true,         
	    		'labels' => array(
	    			'name' => __( $cat_plural ),
	    			'singular_name' => __( $cat_singular ),
	    			'search_items' =>  __( 'Search '.$cat_plural ),
	    			'all_items' => __( 'All '.$cat_plural ),
	    			'parent_item' => __( 'Parent '.$cat_singular ),
	    			'parent_item_colon' => __( 'Parent '.$cat_singular.':' ),
	    			'edit_item' => __( 'Edit '.$cat_singular ),
	    			'update_item' => __( 'Update '.$cat_singular  ),
	    			'add_new_item' => __( 'Add New '.$cat_singular ),
	    			'new_item_name' => __( 'New '.$cat_singular.' Name' )
	    		),
	    		'show_ui' => true,
	    		'query_var' => true,
	    	)
	    ); 
	    
	    
		/** 
		 * Registers a non-hierarchical taxonomy (eg Tags)
		 *
		 * @see http://codex.wordpress.org/Function_Reference/register_taxonomy
		 */
		
		$tag_slug = 'custom_tag';
		$tag_singular = 'Custom Tag';
		$tag_plural = 'Custom Tags';

	    register_taxonomy( $tag_slug, 
	    	array($cpt_slug), 
	    	array('hierarchical' => false,               
	    		'labels' => array(
	    			'name' => __( $tag_plural ),
	    			'singular_name' => __( $tag_singular ),
	    			'search_items' =>  __( 'Search '.$tag_plural ),
	    			'all_items' => __( 'All '.$tag_plural ), 
	    			'parent_item' => __( 'Parent '.$tag_singular ),
	    			'parent_item_colon' => __( 'Parent '.$tag_singular.':' ),
	    			'edit_item' => __( 'Edit '.$tag_singular ),
	    			'update_item' => __( 'Update '.$tag_singular  ),
	    			'add_new_item' => __( 'Add New '.$tag_singular ),
	    			'new_item_name' => __( 'New '.$tag_singular.' Name' )
	    		),
	    		'show_ui' => true,
	    		'query_var' => true,
	    	)
	    ); 

		/** 
		 * Adds Post categories to the custom post type
		 */
			//register_taxonomy_for_object_type('category', $cpt_slug);



		/** 
		 * Adds Post tags to the custom post type
		 */
			//register_taxonomy_for_object_type('post_tag', $cpt_slug);
	    
	} 
}