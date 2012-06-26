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
Test for Permitted Filenames
-------------------------------------------------------------------- */
function gs_permitted_file($included_file) {

  $forbidden = array( 
                'sample',
                'core.php',
                'Copy of',
                '- Copy',
                '(1)',
                '(2)',
                '(3)'
                );

  $required = array(
                'widget.',
                'cpt.',
                'module.'
                );

  $result = false;

  foreach ( $required as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = true;
    }
  }

  foreach ( $forbidden as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = false;
    }
  }

  return $result;

}

/* --------------------------------------------------------------------
Include Permitted PHP files located in /includes/
-------------------------------------------------------------------- */
foreach (glob(__DIR__ . '/*.php') as $file) {

  if ( gs_permitted_file($file) ) {
    include_once $file;
  }

}

/* --------------------------------------------------------------------
Include Permitted PHP files located in direct sub-directories of /includes/
-------------------------------------------------------------------- */
foreach (glob(__DIR__ . '/*/*.php') as $file) {

  if ( gs_permitted_file($file) ) {
    include_once $file;
  }

}

/* --------------------------------------------------------------------

:: Register & Enqueue Core Scripts & Stylesheet

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

:: Remove WP Version Number

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

:: GS Register Sidebar

Function for registering sidebars via class-based templates.  

-------------------------------------------------------------------- */
function gs_register_sidebar($name, $template_type = 'sidebar') {

  $template = new GS_Widget_Templates;
  $id = preg_replace('/[^A-Za-z0-9-]+/', '-', $name);
  $id = strtolower($id);
  $sidebar_id = 'gs-'.$id;

  if ( ($template->$template_type) ) {

    $args = $template->$template_type;
    $args['name'] = $name;
    $args['id'] = $sidebar_id;
    register_sidebar($args);
  
  }

}

/* --------------------------------------------------------------------

:: GS Create Widget

-------------------------------------------------------------------- */
function gs_create_widget($name, $instance = '', $template_type = 'sidebar') {

  $template = new GS_Widget_Templates;

  if (($template->$template_type)) {

    $args = $template->$template_type;

    the_widget($name, $instance, $args );
  
  }

}

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