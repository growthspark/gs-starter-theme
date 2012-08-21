<?php
/**********************************************************************

:: Growth Spark Core Theme Functions

**********************************************************************/

/* --------------------------------------------------------------------

:: Test for Permitted Filenames

Used by the auto-includer in functions.php

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

  $permitted = array(
                'widget.',
                'cpt.',
                'inc.',
                'dashboard.',
                'admin-branding',
                'admin-menu',
                'logo-settings',
                'remove-dashboard-widgets',
                'remove-default-widgets',
                'sidebars-config',
                'tinymce-editor',
                'user-capabilities'
                );

  $result = false;

  foreach ( $permitted as $test ) {
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


function gs_is_admin_include($included_file) {

  $result = false;

   if ( strpos($included_file, 'includes/admin/') ) {
     $result = true;
  }

  return $result;

}


function gs_permitted_include($included_file) {

  $permitted = array(
                'widget.',
                'cpt.',
                'inc.'
                );

  $result = false;

  foreach ( $permitted as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = true;
    }
  }

  return $result;

}

function gs_default_admin_include($included_file) {

  $permitted = array(
                'admin-branding',
                'admin-menu',
                'logo-settings',
                'remove-dashboard-widgets',
                'remove-default-widgets',
                'sidebars-config',
                'tinymce-editor',
                'user-capabilities'
                );

  $result = false;

  foreach ( $permitted as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = true;
    }
  }
  
  return $result;

}


function gs_forbidden_filename($included_file) {

  $forbidden = array( 
                'sample',
                'core.php',
                'Copy of',
                '- Copy',
                '(1)',
                '(2)',
                '(3)'
                );

  $result = false;

  foreach ( $forbidden as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = true;
    }
  }

  return $result;

}


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

Template for displaying comment count.

-------------------------------------------------------------------- */
function gs_comment_count($zero = 'No Comments', $one = '1 Comment', $more = '% Comments', $separator = '|') {
  if((get_comments_number() > 0))  : 
    echo ' '.$separator.' <a href="'.get_permalink().'#comments">';
    comments_number($zero, $one, $more);
    echo '</a>';
  endif;
}


/* --------------------------------------------------------------------

:: GS Show Categories

Template for displaying a post's categories.  
Extends get_the_category_list() by adding parameters for start & end
separators.

-------------------------------------------------------------------- */
function gs_show_categories($start_separator = ' | ', $cat_separator = ', ', $end_separator ='') {

  $categories = get_the_category_list($cat_separator);
  if ( $categories ) {
    return $start_separator.$categories.$end_separator;
  }

}


/* --------------------------------------------------------------------

:: Custom Excerpt function - Differs from the_excerpt

A different way to pull in an excerpt with in-template excerpt length. 
Use is <php gs_content_limit('length');> where 'length' is the number 
of characters. Then that length can have a value passed to it either 
hard-coded or as a theme option - <php gs_content_limit($themeoption);>
It can also be customized below so you can remove the paragraph tags 
or enclose in any other tag.

-------------------------------------------------------------------- */
function gs_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

    if ( isset($_GET['p']) && ( strlen($_GET['p']) > 0 ) ) {
      echo "<p>";
      echo $content;
      echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "</p>";
   }
   else {
      echo "<p>";
      echo $content;
      echo "</p>";
   }
}


/* --------------------------------------------------------------------

:: Get the Post Thumbnail URL

Function for easily returning the URL of a post thumbnail or 
"featured image".  

Parameter $thumbnail_size allows you to specify which image size
you want to use. Default: 'post-thumbnail'.

-------------------------------------------------------------------- */
function gs_post_thumbnail_url( $thumbnail_size = 'post-thumbnail' ) {
  global $post;
 
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $thumbnail_size );
  $url = $thumb['0'];

  return $url;

}