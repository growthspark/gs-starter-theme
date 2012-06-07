<?php
/* --------------------------------------------------------------------
Load Custom Stylesheets for the Admin interface
-------------------------------------------------------------------- */
function gs_load_admin_stylesheet() {
	if ( is_admin() ) {
	wp_enqueue_style( 'gs-admin-styles', get_template_directory_uri() . '/css/admin.css', array(), '1', 'all' );
	}
}
add_action('init','gs_load_admin_stylesheet');

?>