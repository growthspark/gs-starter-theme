<?php
/**
 * Custom Functions Library
 *
 * Contains useful functions that may optionally be used throughout 
 * the theme.  Many are extensions of existing functions from WordPress
 * core or common plugins.
 */

/**
 * Check if a file is safe to include via auto-include
 * 
 * @param str $included_file The name of the file to check
 * @return bool
 */
function gs_permitted_file($included_file) {
  $forbidden = array( 
                'sample',
                'Copy of',
                '- Copy',
                '(1)',
                '(2)',
                '(3)'
                );

  $result = true;

  foreach ( $forbidden as $test ) {
     if ( strpos($included_file, $test) ) {
       $result = false;
    }
  }

  return $result;
}

/**
 * Displays the number of comments for a post.
 *
 * Extends comments_number() by adding start & end separators, and a hyperlink 
 * to the comments section.
 *
 * @param string $zero Content to display when there are no comments
 * @param string $one Content to display when there is one comment
 * @param string $more Content to display when there is more than one comment
 * @param string $start Content to display before the comment count
 * @param string $end Content to display after the comment count
 * @uses comments_number()
 */
function gs_comment_count($zero = 'No Comments', $one = '1 Comment', $more = '% Comments', $start = '|', $end = '') {
  if((get_comments_number() > 0))  : 
    echo $start.'<a href="'.get_permalink().'#comments">';
    comments_number($zero, $one, $more);
    echo '</a>'.$end;
  endif;
}

/**
 * Displays a list of categories for a given post.
 *
 * Extends get_the_category_list() by adding parameters for start & end
 * separators.
 *
 * @param string $start Content to display before the list
 * @param string $separator Content to display in between each category
 * @param string $end Content to display after the list
 * @uses get_the_category_list()
 */
function gs_show_categories($start = ' | ', $separator = ', ', $end ='') {
  $categories = get_the_category_list($separator);
  if ( $categories ) {
    echo $start.$categories.$end;
  }
}

/**
 * Displays an excerpt limited to a certain number of characters.
 *
 * @param int $max_char The maximum number of characters to display
 * @uses get_the_content()
 */
function gs_content_limit($max_char = 200, $post_id = false) {
    global $post;

    if (!$post_id)
      $post_id = $post->ID;

    $post = get_post($post_id);

    $content = $post->post_content;
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

/**
 * Gets the URL for a post thumbnail
 *
 * @global object $post
 * @param string $size The thumbnail size to retrieve
 * @uses wp_get_attachment_image_src()
 * @uses get_post_thumbnail_id()
 */
function gs_post_thumbnail_url( $size = 'post-thumbnail' ) {
  global $post;
  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
  $url = $thumb['0'];
  return $url;
}

/**
 * Return a custom field stored by the Advanced Custom Fields plugin
 * 
 * @global $post
 * @param str $key The key to look for
 * @param mixed $id The post ID (int|str, defaults to $post->ID)
 * @param mixed $default Value to return if get_field() returns nothing
 * @return mixed
 * @uses get_field()
 */
function _get_field( $key, $id=false, $default='' ) {
  global $post;
  $key = trim( filter_var( $key, FILTER_SANITIZE_STRING ) );
  $result = '';
 
  if ( function_exists( 'get_field' ) ) {
    if ( isset( $post->ID ) && !$id )
      $result = get_field( $key );
    else
      $result = get_field( $key, $id );
 
    if ( $result == '' ) // If ACF enabled but key is undefined, return default
      $result = $default;
 
  } else {
    $result = $default;
  }

  return $result;
}

/**
 * Shortcut for 'echo _get_field()'
 * @param str $key The meta key
 * @param mixed $id The post ID (int|str, defaults to $post->ID)
 * @param mixed $default Value to return if there's no value for the custom field $key
 * @return void
 * @uses _get_field()
 */
function _the_field( $key, $id=false, $default='' ) {
  echo _get_field( $key, $id, $default );
}

/**
 * Get a sub field of a Repeater field
 * @param str $key The meta key
 * @param mixed $default Value to return if there's no value for the custom field $key
 * @return mixed
 * @uses get_sub_field()
 */
function _get_sub_field( $key, $default='' ) {
   if ( function_exists( 'get_sub_field' ) &&  get_sub_field( $key ) )  
    return get_sub_field( $key );
   else 
    return $default;
}

/**
 * Shortcut for 'echo _get_sub_field()'
 * @param str $key The meta key Value to return if there's no value for the custom field $key
 * @return void
 * @uses _get_sub_field()
 */
function _the_sub_field( $key, $default='' ) {
  echo _get_sub_field( $key, $default );
}

/**
 * Check if a given field has a sub field
 * @param str $key The meta key
 * @param mixed $id The post ID
 * @return bool
 * @uses has_sub_field()
 */
function _has_sub_field( $key, $id=false ) {
  if ( function_exists('has_sub_field') )
    return has_sub_field( $key, $id );
  else
    return false;
}