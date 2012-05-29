<?php
/** 
Main Functions File
**/

include_once(TEMPLATEPATH . '/includes/core.php');
include_once(TEMPLATEPATH . '/includes/wp-client-friendly-admin/wp-client-friendly-admin.php');
include_once(TEMPLATEPATH . '/includes/sidebar-functions.php');


/* --------------------------------------------------------------------
Add Menus
-------------------------------------------------------------------- */
add_theme_support( 'menus' );   
register_nav_menu('Main', 'Main Navigation Menu');
// register_nav_menu('Your Menu Name', 'Your Menu Description');


/* --------------------------------------------------------------------
Add Template Featured Image Support and custom image sizes
// Call with <php the_post_thumbnail(); > for default thumbnail size or <php the_post_thumbnail('custom-size'); >
-------------------------------------------------------------------- */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
// add_image_size( 'custom-thumb-name', 150, 150, true ); 


/* --------------------------------------------------------------------
Theme Functions
-------------------------------------------------------------------- */



?>