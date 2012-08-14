<?php
/**************************************************************

:: Custom Post Type Template

Based on http://themble.com/bones/

Customized by Growth Spark http://growthspark.com

***************************************************************/

// Create function for the custom type & add it to the WP init action.  
// Function name MUST be unique.


add_action( 'init', 'gs_sample_cpt');

if ( !function_exists('gs_sample_cpt') ) {
	function gs_sample_cpt() { 

		/* ----------------------------------------------------------
		Set Post Type Labels
		-------------------------------------------------------------*/
		$cpt_slug = 'custom-post';
		$singular = 'Custom Post';
		$plural = 'Custom Posts';

		/* ----------------------------------------------------------
		Set Supported Features
		-------------------------------------------------------------*/
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

		/* ----------------------------------------------------------
		Register the Post Type
		-------------------------------------------------------------*/

		register_post_type( $cpt_slug, // (http://codex.wordpress.org/Function_Reference/register_post_type) 
			array('labels' => array(
				'name' => __($plural, 'post type general name'), // This is the Title of the Group 
				'singular_name' => __($singular, 'post type singular name'), // This is the individual type 
				'add_new' => __('Add New '. $singular, 'custom post type item'), // The add new menu item 
				'add_new_item' => __('Add New '. $singular), // Add New Display Title 
				'edit' => __( 'Edit' ), // Edit Dialog 
				'edit_item' => __('Edit '. $singular), // Edit Display Title 
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
				'menu_position' => 8, // this is what order you want it to appear in on the left hand side menu  
				//'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', // the icon for the custom post type menu 
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'has_archive' => true,
				// the next one is important, it tells what's enabled in the post editor 
				'supports' => $supported_features
		 	) // end of options 
		); // end of register post type


		/* ----------------------------------------------------------
		Set up Hierarchical Taxonomy (category)
		-------------------------------------------------------------*/
		
		$cat_slug = 'custom_category';
		$cat_singular = 'Custom Category';
		$cat_plural = 'Custom Categories';

	    register_taxonomy( $cat_slug, 
	    	array($cpt_slug),
	    	array('hierarchical' => true,     // if this is true it acts like categories             
	    		'labels' => array(
	    			'name' => __( $cat_plural ), // name of the custom taxonomy 
	    			'singular_name' => __( $cat_singular ), // single taxonomy name 
	    			'search_items' =>  __( 'Search '.$cat_plural ), // search title for taxomony 
	    			'all_items' => __( 'All '.$cat_plural ), // all title for taxonomies 
	    			'parent_item' => __( 'Parent '.$cat_singular ), // parent title for taxonomy 
	    			'parent_item_colon' => __( 'Parent '.$cat_singular.':' ), // parent taxonomy title 
	    			'edit_item' => __( 'Edit '.$cat_singular ), // edit custom taxonomy title 
	    			'update_item' => __( 'Update '.$cat_singular  ),// update title for taxonomy 
	    			'add_new_item' => __( 'Add New '.$cat_singular ), // add new title for taxonomy 
	    			'new_item_name' => __( 'New '.$cat_singular.' Name' ) // name title for taxonomy 
	    		),
	    		'show_ui' => true,
	    		'query_var' => true,
	    	)
	    ); 
	    
	    
		/* ----------------------------------------------------------
		Set up Non-Hierarchical Taxonomy (tags)
		-------------------------------------------------------------*/
		
		$tag_slug = 'custom_tag';
		$tag_singular = 'Custom Tag';
		$tag_plural = 'Custom Tags';

	    register_taxonomy( 'custom_tag', 
	    	array($cpt_slug), 
	    	array('hierarchical' => false,    // if this is false, it acts like tags                 
	    		'labels' => array(
	    			'name' => __( $tag_plural ), // name of the custom taxonomy 
	    			'singular_name' => __( $tag_singular ), // single taxonomy name 
	    			'search_items' =>  __( 'Search '.$tag_plural ), // search title for taxomony 
	    			'all_items' => __( 'All '.$tag_plural ), // all title for taxonomies 
	    			'parent_item' => __( 'Parent '.$tag_singular ), // parent title for taxonomy 
	    			'parent_item_colon' => __( 'Parent '.$tag_singular.':' ), // parent taxonomy title 
	    			'edit_item' => __( 'Edit '.$tag_singular ), // edit custom taxonomy title 
	    			'update_item' => __( 'Update '.$tag_singular  ),// update title for taxonomy 
	    			'add_new_item' => __( 'Add New '.$tag_singular ), // add new title for taxonomy 
	    			'new_item_name' => __( 'New '.$tag_singular.' Name' ) // name title for taxonomy 
	    		),
	    		'show_ui' => true,
	    		'query_var' => true,
	    	)
	    ); 


		/* ----------------------------------------------------------
		Add your post categories to your custom post type
		-------------------------------------------------------------*/
			//register_taxonomy_for_object_type('category', $cpt_slug);



		/* ----------------------------------------------------------
		Add your post tags to your custom post type
		-------------------------------------------------------------*/
			//register_taxonomy_for_object_type('post_tag', $cpt_slug);
	    
		
		
	} 
}


	

?>