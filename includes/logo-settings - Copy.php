<?php
/**
 * Logo Settings Panel
 *
 * @since Version 1.1
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Version 1.1
 *
 */
function growthspark_logo_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script( 'gs-custom-logo', get_template_directory_uri() . '/js/logo-uploader.js', array('media-upload', 'thickbox'), '1', false );
}
add_action( 'admin_print_styles-appearance_page_logo_options', 'growthspark_logo_enqueue_scripts' );

function growthspark_logo_enqueue_scripts_2( $hook_suffix ){

	wp_enqueue_style('gs-custom-logo-styles',  get_template_directory_uri() . '/css/logo-uploader.css', array(), '1.1', 'all');

}
add_action('admin_head-media-upload-popup','growthspark_logo_enqueue_scripts_2');


/**
 * Register the form setting for our growthspark_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, growthspark_logo_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since Version 1.1
 */
function growthspark_logo_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === growthspark_get_logo_options() )
		add_option( 'growthspark_logo_options', growthspark_get_default_logo_options() );

	register_setting(
		'growthspark_options',       // Options group, see settings_fields() call in growthspark_logo_options_render_page()
		'growthspark_logo_options', // Database option, see growthspark_get_logo_options()
		'growthspark_logo_options_validate' // The sanitization callback, see growthspark_logo_options_validate()
	);

	// Register our settings field group
	add_settings_section(
		'general', // Unique identifier for the settings section
		'', // Section title (we don't want one)
		'__return_false', // Section callback (we don't want anything)
		'logo_options' // Menu slug, used to uniquely identify the page; see growthspark_logo_options_add_page()
	);

	add_settings_field( 'logo_image', __( 'Logo Image',     'growthspark' ), 'growthspark_settings_field_logo_image', 'logo_options', 'general' );
	
}
add_action( 'admin_init', 'growthspark_logo_options_init' );

/**
 * Change the capability required to save the 'growthspark_options' options group.
 *
 * @see growthspark_logo_options_init() First parameter to register_setting() is the name of the options group.
 * @see growthspark_logo_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function growthspark_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_growthspark_options', 'growthspark_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Version 1.1
 */
function growthspark_logo_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Logo', 'growthspark' ),   // Name of page
		__( 'Logo', 'growthspark' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'logo_options',                         // Menu slug, used to uniquely identify the page
		'growthspark_logo_options_render_page' // Function that renders the options page
	);

	if ( ! $theme_page )
		return;

	add_action( "load-$theme_page", 'growthspark_logo_options_help' );
}
add_action( 'admin_menu', 'growthspark_logo_options_add_page' );

function growthspark_logo_options_help() {

	$help = '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, Twenty Eleven, provides the following Theme Options:', 'growthspark' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Color Scheme</strong>: You can choose a color palette of "Light" (light background with dark text) or "Dark" (dark background with light text) for your site.', 'growthspark' ) . '</li>' .
				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'growthspark' ) . '</li>' .
				'<li>' . __( '<strong>Default Layout</strong>: You can choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'growthspark' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'growthspark' ) . '</p>';

	$sidebar = '<p><strong>' . __( 'For more information:', 'growthspark' ) . '</strong></p>' .
		'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_logo_options_Screen" target="_blank">Documentation on Theme Options</a>', 'growthspark' ) . '</p>' .
		'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'growthspark' ) . '</p>';

	$screen = get_current_screen();

	if ( method_exists( $screen, 'add_help_tab' ) ) {
		// WordPress 3.3
		$screen->add_help_tab( array(
			'title' => __( 'Overview', 'growthspark' ),
			'id' => 'theme-options-help',
			'content' => $help,
			)
		);

		$screen->set_help_sidebar( $sidebar );
	} else {
		// WordPress 3.2
		add_contextual_help( $screen, $help . $sidebar );
	}
}


/**
 * Returns the default options for Twenty Eleven.
 *
 * @since Version 1.1
 */
function growthspark_get_default_logo_options() {
	$default_logo_options = array(
		'color_scheme' => 'light',
		'theme_layout' => 'content-sidebar',
	);

	if ( is_rtl() )
 		$default_logo_options['theme_layout'] = 'sidebar-content';

	return apply_filters( 'growthspark_default_logo_options', $default_logo_options );
}

/**
 * Returns the options array for Twenty Eleven.
 *
 * @since Version 1.1
 */
function growthspark_get_logo_options() {
	return get_option( 'growthspark_logo_options', growthspark_get_default_logo_options() );
}


/**
 * Renders the Logo Image setting field.
 *
 * 
 */

function growthspark_settings_field_logo_image() {
	$options = growthspark_get_logo_options();

			// Sanitize
			$id = 'logo_image';
			$value = ( isset($options[$id]) && !empty($options[$id]) ) ? esc_url($options[$id]) : '';
			$field = '<p class="upload-field">
				<input name="growthspark_logo_options[' . $id . ']' . '" id="gs-logo-upload" type="text" value="' . $value . '" size="40" />
				<input type="button" id="gs-logo-upload-button" class="button-secondary media-library-upload" rel="growthspark_logo_options[' . $id . ']' . '" alt="Set Logo" value="Set Logo" />
				<input type="button" class="button-secondary media-library-remove" rel="growthspark_logo_options[' . $id . ']' . '" value="Remove Logo" />
			</p>';

			if ( !empty($value) )
				$field .= '<p><span class="logo-preview-box"><img src="' . $value . '" class="upload-image-preview" /></span></p>';

		echo $field;

}

/**
 * Renders the Layout setting field.
 *
 * @since Version 1.1
 */
function growthspark_settings_field_layout() {
	$options = growthspark_get_logo_options();
	foreach ( growthspark_layouts() as $layout ) {
		?>
		<div class="layout image-radio-option theme-layout">
		<label class="description">
			<input type="radio" name="growthspark_logo_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
			<span>
				<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>" width="136" height="122" alt="" />
				<?php echo $layout['label']; ?>
			</span>
		</label>
		</div>
		<?php
	}
}

/**
 * Returns the options array for Twenty Eleven.
 *
 * @since Twenty Eleven 1.2
 */
function growthspark_logo_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( 'Logo Options', 'growthspark' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'growthspark_options' );
				do_settings_sections( 'logo_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see growthspark_logo_options_init()
 * @todo set up Reset Options action
 *
 * @since Version 1.1
 */
function growthspark_logo_options_validate( $input ) {
	$output = $defaults = growthspark_get_default_logo_options();

	$output['logo_image'] = esc_url($input['logo_image']);

	return apply_filters( 'growthspark_logo_options_validate', $output, $input, $defaults );
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since Version 1.1
 */
function growthspark_enqueue_color_scheme() {
	$options = growthspark_get_logo_options();
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );

	do_action( 'growthspark_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'growthspark_enqueue_color_scheme' );

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Version 1.1
 */
function growthspark_print_link_color_style() {
	$options = growthspark_get_logo_options();
	$link_color = $options['link_color'];

	$default_options = growthspark_get_default_logo_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		.widget_growthspark_ephemera .comments-link a:hover,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover {
			color: <?php echo $link_color; ?>;
		}
		section.recent-posts .other-recent-posts .comments-link a:hover {
			border-color: <?php echo $link_color; ?>;
		}
		article.feature-image.small .entry-summary p a:hover,
		.entry-header .comments-link a:hover,
		.entry-header .comments-link a:focus,
		.entry-header .comments-link a:active,
		.feature-slider a.active {
			background-color: <?php echo $link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'growthspark_print_link_color_style' );

/**
 * Adds Twenty Eleven layout classes to the array of body classes.
 *
 * @since Version 1.1
 */
function growthspark_layout_classes( $existing_classes ) {
	$options = growthspark_get_logo_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );
	else
		$classes = array( 'one-column' );

	if ( 'content-sidebar' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'sidebar-content' == $current_layout )
		$classes[] = 'left-sidebar';
	else
		$classes[] = $current_layout;

	$classes = apply_filters( 'growthspark_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'growthspark_layout_classes' );