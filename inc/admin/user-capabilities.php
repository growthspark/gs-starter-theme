<?php
/**
 * Customizes WordPress user capabilities
 *
 * @global object $wp_roles
 * @link http://codex.wordpress.org/Roles_and_Capabilities
 */
function gs_custom_user_capabilities() {
	global $wp_roles;

	if (class_exists('WP_Roles'))
		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();	

	if (is_object($wp_roles)) {

		/**
		 * Administrator
		 */
		$wp_roles->remove_cap( 'administrator', 'manage_links' );
		$wp_roles->remove_cap( 'administrator', 'edit_plugins' );

		/**
		 * Editor
		 */
		$wp_roles->add_cap( 'editor', 'edit_theme_options' );
		$wp_roles->remove_cap( 'editor', 'manage_links' );

	}
}
add_action( 'after_switch_theme', 'gs_custom_user_capabilities' );