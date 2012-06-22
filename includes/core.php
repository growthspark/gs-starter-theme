<?php
/**
Core GrowthSpark Theme File

DO NOT CUSTOMIZE this file unless it's absolutely necessay.

Custom functions should be configured in functions.php
**/


/* --------------------------------------------------------------------
:: Auto-Includer

Loads PHP files from the /includes/ directory.

-------------------------------------------------------------------- */

/* --------------------------------------------------------------------
Include PHP files located in /includes/
-------------------------------------------------------------------- */
foreach (glob(__DIR__ . '/*.php') as $my_theme_filename) {

  if (!strpos($my_theme_filename, 'sample.php') && !strpos($my_theme_filename, 'core.php') ) {
      include_once $my_theme_filename;
  }

}

/* --------------------------------------------------------------------
Include PHP files located in direct sub-directories of /includes/
-------------------------------------------------------------------- */
foreach (glob(__DIR__ . '/*/*.php') as $my_theme_filename) {

  if (!strpos($my_theme_filename, '-sample') ) {
      include_once $my_theme_filename;
  }

}

/* --------------------------------------------------------------------
Register & Enqueue Core Scripts & Stylesheet
-------------------------------------------------------------------- */
function gs_enqueue_scripts() {
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

  }
}
// enqueue base scripts and styles
add_action('template_redirect', 'gs_enqueue_scripts', 1);


/* --------------------------------------------------------------------
Remove WP Version Number
-------------------------------------------------------------------- */
remove_action('wp_head', 'wp_generator');


/* --------------------------------------------------------------------

:: JavaScript Variables

Set global variables for use in JavaScript files

-------------------------------------------------------------------- */
function gs_set_javascript_variables() {
?>
<script>
    var siteurl = '<?php bloginfo('url'); ?>';
    var templateurl = '<?php bloginfo('template_url'); ?>';
</script>

<?
}
add_action('wp_head', 'gs_set_javascript_variables', 1);


/* --------------------------------------------------------------------

:: GS Comment Count

Template for displaying comment count

-------------------------------------------------------------------- */
function gs_comment_count() {
  if((get_comments_number() > 0))  : 
  ?>
    &nbsp;| &nbsp;<a href="<?php the_permalink(); ?>#comments"><?php comments_number('no comments','1 comment','% comments'); ?></a>
  <?php 
  endif;
}

?>