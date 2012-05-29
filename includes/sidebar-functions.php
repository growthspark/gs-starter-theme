<?php

/* ----------------------------------------------------------
Build Widget Areas
------------------------------------------------------------- */
if ( function_exists('register_sidebars') )
    register_sidebar(array('name'=>'Main Sidebar',
        'before_widget' => '<li>',
        'after_widget' => '</li>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
     ));

/* ----------------------------------------------------------
Remove Default Widgets
------------------------------------------------------------- */

function unregister_default_wp_widgets() {
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Widget_Custom_Menu');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);

?>