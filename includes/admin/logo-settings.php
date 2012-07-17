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
 * Register the form setting for our growthspark_logo_options array.
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
		'growthspark_logo_options',       // Options group, see settings_fields() call in growthspark_logo_options_render_page()
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
 * Change the capability required to save the 'growthspark_logo_options' options group.
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
add_filter( 'option_page_capability_growthspark_logo_options', 'growthspark_option_page_capability' );

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
}
add_action( 'admin_menu', 'growthspark_logo_options_add_page' );




/**
 * Returns the default options.
 *
 * @since Version 1.1
 */
function growthspark_get_default_logo_options() {
	$default_logo_options = array(
		'logo_image' => get_template_directory_uri().'/img/logo.png',

	);

	return apply_filters( 'growthspark_default_logo_options', $default_logo_options );
}

/**
 * Returns the options array.
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
 * Returns the options array.
 *
 * @since Version 1.1
 */
function growthspark_logo_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( 'Logo Options', 'growthspark' ), get_current_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'growthspark_logo_options' );
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
 *
 * @since Version 1.1
 */
function growthspark_logo_options_validate( $input ) {
	$output = $defaults = growthspark_get_default_logo_options();

	$output['logo_image'] = esc_url($input['logo_image']);

	return apply_filters( 'growthspark_logo_options_validate', $output, $input, $defaults );
}


/**
 * Functions for returning key logo data 
 *
 *
 * @since Version 1.1
 */
function gs_get_logo() {
	    $defaults = growthspark_get_default_logo_options();
        $option = get_option('growthspark_logo_options', $defaults);
        return $option['logo_image'];
}
function gs_logo_width() {
	    $defaults = growthspark_get_default_logo_options();
        $option = get_option('growthspark_logo_options', $defaults);
        $logo_size = getimagesize($option['logo_image']);
        return $logo_size[0];
}

function gs_logo_height() {
	    $defaults = growthspark_get_default_logo_options();
        $option = get_option('growthspark_logo_options', $defaults);
        $logo_size = getimagesize($option['logo_image']);
        return $logo_size[1];
}