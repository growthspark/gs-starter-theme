<?php
/**********************************************************************

:: Main Functions File

**********************************************************************/

/* --------------------------------------------------------------------

:: Load Core Theme File

This auto-loads files in the /includes/ folder so you don't need to
include them here manually.  See: /includes/readme.txt for documentation.
-------------------------------------------------------------------- */
include_once(TEMPLATEPATH . '/includes/core.php');

/* --------------------------------------------------------------------
Add Menus
-------------------------------------------------------------------- */
add_theme_support( 'menus' );   
register_nav_menu('main', 'Main Navigation Menu');
// register_nav_menu('Your Menu Name', 'Your Menu Description');

/* --------------------------------------------------------------------
Add Template Featured Image Support and custom image sizes
-------------------------------------------------------------------- */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
add_image_size( 'slide', 960, 300, true );
// add_image_size( 'custom-thumb-name', 150, 150, true ); 


/* --------------------------------------------------------------------

:: Theme Functions

Place custom theme functions below.

-------------------------------------------------------------------- */

/* --------------------------------------------------------------------
Configure Theme Stylesheets

http://codex.wordpress.org/Function_Reference/wp_enqueue_style
-------------------------------------------------------------------- */
function gs_register_stylesheets() {
    wp_enqueue_style( 'gs-base', get_template_directory_uri() . '/css/base.css', array(), '1', 'all' );
    wp_enqueue_style( 'gs-grid', get_template_directory_uri() . '/css/grid.css', array('gs-base'), '1', 'all' );
    wp_enqueue_style( 'gs-theme-styles', get_template_directory_uri() . '/style.css', array('gs-base', 'gs-grid'), '1', 'all' );
}
add_action('template_redirect', 'gs_register_stylesheets');

/* --------------------------------------------------------------------
Load jQuery Cycle
-------------------------------------------------------------------- */
function gs_load_jquery_cycle() {

	if ( is_front_page() ) { // Load jQuery cycle only on the homepage

    wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '1', false );
    wp_enqueue_script( 'jquery-cycle' );

	}

}
add_action('template_redirect', 'gs_load_jquery_cycle');

/* --------------------------------------------------------------------
Load jQuery Cycle Settings
-------------------------------------------------------------------- */
function gs_jquery_cycle_settings() {
	
	if ( is_front_page() ) {  ?>

	<script>
		jQuery(document).ready(function() {

		  jQuery('#slideshow')
		  .after('<div id="slide-nav">')
		  .cycle({ 
		      fx:      'fade', 
		      speed:    1000, 
		      timeout:  6000,   
		      pager:    '#slide-nav',
		      slideResize: 0,
		      containerResize: 0
		  });

		  jQuery('#slide-nav a').addClass('ir');

		});
	</script>
	<?php 

	}
}
add_action('wp_footer', 'gs_jquery_cycle_settings');

?>