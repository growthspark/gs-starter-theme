<?php
/**
 * Theme functions and definitions
 *
 */


/**
 * Sets up theme defaults and registers the various WordPress features
 * supported by the theme.
 *
 * @uses gs_permitted_file() To verify files before auto-inclusion
 * @uses add_theme_support() To add support for post thumbnails.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 * @uses add_image_size() To set sizes for featured images.
 */
function gs_theme_setup() {

	/**
	 * Load the theme functions library
	 */
	require_once('inc/library.php');

	/**
	 * Load custom post types
	 */
	require_once('inc/cpt.slides.php'); 

	/**
	 * Load custom widgets
	 */
	require_once('inc/widget.feature-box/widget.feature-box.php'); 
	require_once('inc/widget.gs-recent-posts/widget.gs-recent-posts.php'); 

	/**
	 * Load custom admin features
	 */
	require_once('inc/admin/admin-branding.php'); 
	require_once('inc/admin/admin-menu.php'); 
	require_once('inc/admin/dashboard.recent-drafts.php'); 
	require_once('inc/admin/remove-dashboard-widgets.php'); 
	require_once('inc/admin/remove-default-widgets.php'); 
	require_once('inc/admin/tinymce-editor.php'); 
	require_once('inc/admin/user-capabilities.php'); 

 	/**
     * Removes WordPress version number from the document head (for security).
	 *
     */	
	remove_action('wp_head', 'wp_generator');

 	/**
     * Registers theme menus.
     */	
	register_nav_menu('main', 'Main Navigation Menu');
	//register_nav_menu('Your Menu Name', 'Your Menu Description');

 	/**
     * Registers thumbnail and featured image sizes.
     */	
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
	add_image_size( 'slide', 960, 300, true );
	//add_image_size( 'custom-thumb-name', 150, 150, true ); 

}
add_action( 'after_setup_theme', 'gs_theme_setup' );


/**
 * Registers the theme's widget areas.
 *
 * @uses register_sidebar()
 */
function gs_widgets_init() {
	register_sidebar(
	    array(
	        'name'          => 'Homepage Widgets',
	        'id'            => 'homepage-widgets',
	        'description'   => '',
	        'before_widget' => '<div id="%1$s" class="home-widget %2$s four columns"><div class="widget-container">',
	        'after_widget'  => '</div></div>',
	        'before_title'  => '<h4>',
	        'after_title'   => '</h4>',           
	    ));

	register_sidebar(
	    array(
	        'name'          => 'Page Sidebar',
	        'id'            => 'page-sidebar',
	        'description'   => '',
	        'before_widget' => '<div id="%1$s" class="%2$s side-widget">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4>',
	        'after_title'   => '</h4>',           
	    ));

	register_sidebar(
	    array(
	        'name'          => 'Blog Sidebar',
	         'id'            => 'blog-sidebar',
	        'description'   => '',
	        'before_widget' => '<div id="%1$s" class="%2$s side-widget">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4>',
	        'after_title'   => '</h4>',           
	    ));
}
add_action('widgets_init', 'gs_widgets_init');


/**
 * Sets license keys upon theme activation
 * 
 * Runs only when the theme is first activated.  Useful for automatically
 * populating license keys for various plugins & extensions.
 * 
 * In order for this to work you'll need to first set the license keys by
 * defining constants in your wp-config.php file.
 *
 * @link http://seanbutze.com/automatically-load-wordpress-license-keys-with-wp-config-php/ 
 *
 */
function gs_set_keys() {
	if ( !get_option('acf_options_page_ac') && defined('ACF_OPTIONS_KEY') )
		update_option('acf_options_page_ac', ACF_OPTIONS_KEY);

	if ( !get_option('acf_repeater_ac') && defined('ACF_REPEATER_KEY') )
		update_option('acf_repeater_ac', ACF_REPEATER_KEY);
}
add_action('after_switch_theme', 'gs_set_keys');


/**
 * Enqueues scripts and styles for front-end.
 *
 * @uses wp_enqueue_style()
 * @uses wp_enqueue_script()
 */
function gs_scripts_styles() {
	/*
	 * Loads web fonts.
	 */
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'gs-web-fonts', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald", array(), null );

	/*
	 * Loads theme stylesheets.
	 */
	wp_enqueue_style( 'gs-base-styles', get_template_directory_uri() . '/css/base.css', array(), '1', 'all' );
  	wp_enqueue_style( 'gs-theme-styles', get_template_directory_uri() . '/style.css', array('gs-base-styles'), '1', 'all' );

	/*
	 * Includes Mordernizr in the head.
	 */
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '1', false );

	/*
	 * Adds scripts.js in the footer.
	 */
  	wp_enqueue_script( 'gs-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'modernizr', 'jquery' ), '1', true );

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Loads jQuery Cycle on the homepage only.
	 */
	if ( is_front_page() )
    	wp_enqueue_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '1', false );
}
add_action('wp_enqueue_scripts', 'gs_scripts_styles');


/**
 * Adds support for CSS box-sizing in IE6-7
 *
 * The fluid grid system in base.css requires this polyfill
 * in order to work in legacy browsers.
 *
 * @uses wp_enqueue_style()
 */
function gs_add_box_sizing_support(){
	?>
	<style type="text/css">
		* { *behavior: url('<?php bloginfo('template_url') ?>/boxsizing.htc'); }
	</style>
	<?php
}
add_action('wp_head', 'gs_add_box_sizing_support');


/**
 * Enqueues scripts and styles for the admin panels.
 * @uses wp_enqueue_style()
 */
function gs_admin_scripts_styles() {
	/*
	 * Loads admin.css
	 */
	wp_enqueue_style( 'gs-admin-styles', get_template_directory_uri() . '/css/admin.css', array(), '1', 'all' );
}
add_action('admin_enqueue_scripts','gs_admin_scripts_styles');


/**
 * Add Modernizr tests in the footer.
 */
function gs_load_modernizr_tests() {
?>
<!-- Modernizr Tests -->
<script type="text/javascript">
	Modernizr.load([{
		/* Support CSS Selectors in IE 6-8 */

		// Test for border-radius support (effectively tests for IE 6-8)
	    test : Modernizr.borderradius,
	    // Load Selectivizr to enable CSS selectors in IE 6-8
	    nope : ['<?php bloginfo('template_url');?>/js/selectivizr.min.js']

	}]);
</script>
<!--/ Modernizr Tests -->
<?php
}
add_action('wp_footer', 'gs_load_modernizr_tests');


/**
 * Add jQuery Cycle settings in the footer.
 */
function gs_jquery_cycle_settings() {
	
	if ( is_front_page() ) {  ?>
	<!-- jQuery Cycle Settings -->
	<script type="text/javascript">
		jQuery(document).ready(function() {

		  jQuery('#slideshow')
		  .after('<div id="slide-nav">')
		  .cycle({ 
		      fx:      'fade', 
		      speed:    1000, 
		      timeout:  6000,   
		      pager:    '#slide-nav',
		      slideResize: 0,
		      containerResize: 0
		  });

		  jQuery('#slide-nav a').addClass('ir');

		});
	</script>
	<!--/ jQuery Cycle Settings -->
	<?php 
	}
}
add_action('wp_footer', 'gs_jquery_cycle_settings');


/**
 * Displays pagination for archive & search pages.
 *
 * @global object $wp_query
 * @uses paginate_links()
 */
function gs_pagination($query = false) {
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

  $args = array(
	'base' => $base,
    'format' => 'page/%#%',
    'current' => $current_page,
    'total' => $total_pages,
	);

  if ($total_pages > 1){
    echo '<div class="pagination">';
    echo paginate_links($args);
    echo '</div>';
  }
  $wp_query = $temp;
}


?>