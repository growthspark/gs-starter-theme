<?php
/**************************************************************

:: Sidebars Configuration File

I. Set Widget Templates
II. Build Widget Areas

***************************************************************/

/* ----------------------------------------------------------

I. Set Widget Templates

------------------------------------------------------------- */
function gs_before_widget() {
  return '<div id="%1$s" class="%2$s side-widget">';
}
function gs_after_widget() {
  return '</div>';
}
function gs_before_title() {
  return '<h4>';
}
function gs_after_title() {
  return '</h4>';
}
function gs_home_before_widget() {
  return '<div id="%1$s" class="home-widget %2$s four columns"><div class="widget-container">';
}
function gs_home_after_widget() {
  return '</div></div>';
}

/* ----------------------------------------------------------

II. Build Widget Areas

------------------------------------------------------------- */
if ( function_exists('register_sidebars') )
    register_sidebar(array(
        'name'=>'Homepage Widgets',
        'id' => 'homepage-widgets',
        'before_widget' => gs_home_before_widget(),
        'after_widget' => gs_home_after_widget(),
        'before_title' => gs_before_title(),
        'after_title' => gs_after_title(),
     ));

if ( function_exists('register_sidebars') )
    register_sidebar(array(
        'name'=>'Page Sidebar',
        'id' => 'page-sidebar',
        'before_widget' => gs_before_widget(),
        'after_widget' => gs_after_widget(),
        'before_title' => gs_before_title(),
        'after_title' => gs_after_title(),
     ));

if ( function_exists('register_sidebars') )
    register_sidebar(array(
        'name'=>'Blog Sidebar',
        'id' => 'blog-sidebar',
        'before_widget' => gs_before_widget(),
        'after_widget' => gs_after_widget(),
        'before_title' => gs_before_title(),
        'after_title' => gs_after_title(),
     ));

?>