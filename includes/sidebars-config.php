<?php
/**************************************************************

:: Sidebars Configuration File

I. Set Widget Templates
II. Register Widget Areas (Sidebars)

***************************************************************/


/* ----------------------------------------------------------

I. Set Widget Templates

------------------------------------------------------------- */
Class GS_Widget_Templates {

  public $sidebar = array( 
        'before_widget' => '<div id="%1$s" class="%2$s side-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    );

  public $home = array( 
        'before_widget' => '<div id="%1$s" class="home-widget %2$s four columns"><div class="widget-container">',
        'after_widget' => '</div></div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    );

}

/** ----------------------------------------------------------

II. Build Widget Areas

gs_register_sidebar($name, $template_type)

$name - required - The name of the sidebar to be registered

$template_type - optional - The front-end template that widgets 
in the sidebar should use.  Templates are set above in 
GS_Widget_Templates.   (default: 'sidebar')

------------------------------------------------------------- */
gs_register_sidebar('Homepage Widgets', 'home');
gs_register_sidebar('Page Sidebar');
gs_register_sidebar('Blog Sidebar');