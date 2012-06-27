<?php
/**********************************************************************

:: Main Functions File

**********************************************************************/

/* --------------------------------------------------------------------

:: Set Up Default Theme Features
-------------------------------------------------------------------- */
add_action( 'after_setup_theme', 'gs_theme_setup' );
function gs_theme_setup() {

	/* --------------------------------------------------------------------
	Load Core Theme File
	-------------------------------------------------------------------- */
	include_once(TEMPLATEPATH . '/includes/core.php');

	/* --------------------------------------------------------------------
	
	Auto-Includer

	This automatically includes permitted files in the /includes/ directory
	so you don't have to include them here manually.  See includes/readme.txt
	for documentation.

	-------------------------------------------------------------------- */
	// Include Permitted PHP files located in /includes/
	foreach (glob(__DIR__ . '/includes/*.php') as $file) {
	  if ( gs_permitted_file($file) ) 
	    include_once $file;
	}
	// Include Permitted PHP files located in direct sub-directories of /includes/
	foreach (glob(__DIR__ . '/includes/*/*.php') as $file) {
	  if ( gs_permitted_file($file) ) 
	    include_once $file;
	}

	/* --------------------------------------------------------------------
	Remove WP Version Number (for security)
	-------------------------------------------------------------------- */
	remove_action('wp_head', 'wp_generator');

	/* --------------------------------------------------------------------
	Add Menus
	-------------------------------------------------------------------- */
	add_theme_support( 'menus' );   
	register_nav_menu('main', 'Main Navigation Menu');
	// register_nav_menu('Your Menu Name', 'Your Menu Description');

	/* --------------------------------------------------------------------
	Add Template Featured Image Support and custom image sizes
	-------------------------------------------------------------------- */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
	add_image_size( 'slide', 960, 300, true );
	// add_image_size( 'custom-thumb-name', 150, 150, true ); 

	/* --------------------------------------------------------------------
	Enable Custom Header Support (For Logos)
	-------------------------------------------------------------------- */
	$defaults = array(
		'default-image'          => get_template_directory_uri().'/img/logo.png',
		'random-default'         => false,
		'width'                  => 217,
		'height'                 => 80,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );

} // gs_theme_setup


/* --------------------------------------------------------------------
:: Configure Theme Styles

http://codex.wordpress.org/Function_Reference/wp_enqueue_style
-------------------------------------------------------------------- */
function gs_load_stylesheets() {
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald', array(), '1', 'all' );
    wp_enqueue_style( 'gs-base', get_template_directory_uri() . '/css/base.css', array('google-fonts'), '1', 'all' );
    wp_enqueue_style( 'gs-theme-styles', get_template_directory_uri() . '/style.css', array('google-fonts', 'gs-base'), '1', 'all' );
}
add_action('wp_enqueue_scripts', 'gs_load_stylesheets');


/* --------------------------------------------------------------------
:: Load Custom Stylesheets for the Admin interface
-------------------------------------------------------------------- */
function gs_load_admin_stylesheet() {
	wp_enqueue_style( 'gs-admin-styles', get_template_directory_uri() . '/css/admin.css', array(), '1', 'all' );
}
add_action('admin_enqueue_scripts','gs_load_admin_stylesheet');


/* --------------------------------------------------------------------
:: Load JavaScript Files
------------------------------------------------------------------- */
function gs_enqueue_scripts() {
  if (!is_admin()) {
  // include modernizr in the head
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array(), '1', false );
    // include comment-reply.js only when comments are present & threaded comments are enabled
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

	// Add scripts.js file in the footer
    wp_enqueue_script( 'gs-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'modernizr', 'jquery' ), '1', true );

  }
}
add_action('template_redirect', 'gs_enqueue_scripts', 1);


/* ----------------------------------------------------------

:: Load Modernizr Tests

We can use Modernizr.load to load certain resources
only when they're needed.

-------------------------------------------------------------*/
function gs_load_modernizr_tests() {
?>
<script>
	Modernizr.load([{
			/* Support CSS Selectors in IE 6-8 */

			// Test for border-radius support (effectively tests for IE 6-8)
		    test : Modernizr.borderradius,
		    // Load Selectivizr to enable CSS selectors in IE 6-8
		    nope : ['<?php bloginfo('template_url');?>/js/selectivizr.min.js']

	}]);
</script>
<?php
}
add_action('wp_footer', 'gs_load_modernizr_tests');


/* --------------------------------------------------------------------
:: Load jQuery Cycle
-------------------------------------------------------------------- */
function gs_load_jquery_cycle() {

	if ( is_front_page() ) { // Load jQuery cycle only on the homepage

    wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '1', false );
    wp_enqueue_script( 'jquery-cycle' );

	}
}
add_action('template_redirect', 'gs_load_jquery_cycle');


/* --------------------------------------------------------------------
:: Load jQuery Cycle Settings
-------------------------------------------------------------------- */
function gs_jquery_cycle_settings() {
	
	if ( is_front_page() ) {  ?>

	<script>
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
	<?php 

	}
}
add_action('wp_footer', 'gs_jquery_cycle_settings');


?>