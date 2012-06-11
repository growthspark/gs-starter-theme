<?php
/**************************************************************

:: Sidebars Configuration File

I. Set Widget Templates
II. Build Widget Areas
III. Set Default Sidebar Content

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


/* ----------------------------------------------------------

III. Set Default Sidebar Content

Used in sidebar.php to generate default widgets when none have 
been set by the user

------------------------------------------------------------- */
function gs_default_home_widgets() {

  for ($i = 1; $i <= 3; $i++) {

      the_widget('GS_Feature_Box',
        array(
              'title' => 'Lorem Ipsum',
              'text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.',
              'linktext' => 'Read More',
              'linkurl' => '#',
              'filter' => 1,
            ),
        array( 
          'before_widget' => gs_home_before_widget(),
              'after_widget' => gs_home_after_widget(),
              'before_title' => gs_before_title(),
              'after_title' => gs_after_title()
            )
      );

  }

}

function gs_default_sidebar_widgets() {

    the_widget('WP_Widget_Search',
      array(
        
          ),
      array( 
        'before_widget' => gs_before_widget(),
            'after_widget' => gs_after_widget(),
            'before_title' => gs_before_title(),
            'after_title' => gs_after_title()
          )
    );

      the_widget('GS_Feature_Box',
        array(
              'title' => 'Lorem Ipsum',
              'text' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.',
              'linktext' => 'Read More',
              'linkurl' => '#',
              'filter' => 1,
            ),
        array( 
          'before_widget' => gs_before_widget(),
              'after_widget' => gs_after_widget(),
              'before_title' => gs_before_title(),
              'after_title' => gs_after_title()
            )
      );
}

?>