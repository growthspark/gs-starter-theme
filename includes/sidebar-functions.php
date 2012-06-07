<?php

/* ----------------------------------------------------------
Build Widget Areas
------------------------------------------------------------- */
if ( function_exists('register_sidebars') )
    register_sidebar(array('name'=>'Homepage Widgets',
        'before_widget' => '<div id="%1$s" class="home-widget %2$s four columns"><div class="widget-container">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
     ));

if ( function_exists('register_sidebars') )
    register_sidebar(array('name'=>'Default Page Sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s side-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
     ));

if ( function_exists('register_sidebars') )
    register_sidebar(array('name'=>'Blog Sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s side-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
     ));

/* ----------------------------------------------------------
Remove Default Widgets
------------------------------------------------------------- */

function unregister_default_wp_widgets() {
  unregister_widget('WP_Widget_Calendar');
  //unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Recent_Comments');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Pages');
  //unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Categories');
  unregister_widget('WP_Widget_Text');
  //unregister_widget('WP_Widget_Custom_Menu');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);

?>