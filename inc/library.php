<?php
/**
 * Custom Functions Library
 *
 * Contains useful functions that may optionally be used throughout 
 * the theme.  Many are extensions of existing functions from WordPress
 * core or common plugins.
 */

/**
 * Print contents of a variable in user-friendly
 * pre-formatted output.
 * 
 * @param mixed $var The variable to debug
 */
function gs_debug($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
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
function gs_content_limit($max_char = 200, $post_id = false, $more = false) {
    global $post;

    if (!$post_id)
      $post_id = $post->ID;

    $temp = $post;
    $post = get_post($post_id);

    $content = $post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

    if ( isset($_GET['p']) && ( strlen($_GET['p']) > 0 ) ) {
      echo "<p>";
      echo $content;
      if ($more) {
        echo " <a href='".get_permalink($post->ID)."'>".$more."</a>";
      }
      echo "</p>";
   }
   
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        if ($more) {
          echo " <a href='".get_permalink($post->ID)."'>".$more."</a>";
        }
        echo "</p>";
   }
   else {
      echo "<p>";
      echo $content;
      if ($more) {
        echo " <a href='".get_permalink($post->ID)."'>".$more."</a>";
      }
      echo "</p>";
   }
   $post = $temp;
}

/**
 * Gets the URL for a post thumbnail
 *
 * @global object $post
 * @param string $size The thumbnail size to retrieve
 * @uses wp_get_attachment_image_src()
 * @uses get_post_thumbnail_id()
 */
function gs_post_thumbnail_url( $size = 'post-thumbnail', $post_id = false ) {
  global $post;

  if (!$post_id)
    $post_id = $post->ID;

  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $size );
  $url = $thumb['0'];
  return $url;
}

/**
 * Displays pagination for archive & search pages.
 *
 * @global object $wp_query
 * @uses paginate_links()
 */
function gs_pagination($args = array(), $query = false) {
  global $wp_query;
  $temp = $wp_query;
  if ($query) $wp_query = $query;
  $current_page = max(1, get_query_var('paged'));
  $total_pages = $wp_query->max_num_pages;

  if ( is_search() || is_post_type_archive() ) {  // Special treatment needed for search & archive pages
    $big = '999999999';
    $base = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
  } else {
    $base = get_pagenum_link(1) . '%_%';
  }

  $defaults = array(
    'base' => $base,
    'format' => 'page/%#%',
    'current' => $current_page,
    'total' => $total_pages,
  );

  $args = wp_parse_args($args, $defaults);

  if ($total_pages > 1){
    echo '<div class="pagination">';
    echo paginate_links($args);
    echo '</div>';
  }
  $wp_query = $temp;
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
  $key = trim(filter_var($key, FILTER_SANITIZE_STRING));
  $result = '';

  if (!$id)
    $id = $post->ID;
 
  if (function_exists('get_field')) {
    if (get_field($key, $id))
      $result = get_field($key, $id);
    if ($result == '')
      $result = $default;
  } elseif ($id == 'options') {
      $result = get_option('options_'.$key, $default);
  } elseif (get_post_meta($id, $key, true)) {
    $result = get_post_meta($id, $key, true);
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