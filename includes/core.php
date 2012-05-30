<?php
/**
Core GrowthSpark Theme File

DO NOT CUSTOMIZE this file unless it's absolutely necessay.

Custom functions should be configured in functions.php
**/


/* --------------------------------------------------------------------
Register & Enqueue Core Scripts & Stylesheet
-------------------------------------------------------------------- */
function gs_queue_js_and_css() {
  if (!is_admin()) {
  // include modernizr in the head
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '1', false );
    wp_enqueue_script( 'modernizr' );
    // include comment-reply.js only when comments are present & threaded comments are enabled
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

	// Add scripts.js file in the footer
    wp_register_script( 'gs-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'modernizr', 'jquery' ), '1', true );
    wp_enqueue_script( 'gs-scripts' );

	// Register main stylesheet
    wp_register_style( 'gs-styles', get_template_directory_uri() . '/style.css', array(), '1', 'all' );
    wp_enqueue_style( 'gs-styles' );
  }
}
// enqueue base scripts and styles
add_action('wp_enqueue_scripts', 'gs_queue_js_and_css', 1);]


/* --------------------------------------------------------------------
Remove WP Version Number
-------------------------------------------------------------------- */
remove_action('wp_head', 'wp_generator');


?>