<?php
/*********************************************************************
**                              
** Custom User Capabilities                                    
** 
** For full list of capabilities, see:
** http://codex.wordpress.org/Roles_and_Capabilities 
**                                
**********************************************************************/

<<<<<<< HEAD
add_action( 'after_switch_theme', 'gs_custom_user_capabilities' );
=======
add_action( 'init', 'gs_custom_user_capabilities' );
>>>>>>> parent of 76b0eef... Repo moved
function gs_custom_user_capabilities() {
	global $wp_roles;

	if (class_exists('WP_Roles'))
		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();	

	if (is_object($wp_roles)) {

		/* --------------------------------------------------------------------
		:: Administrator
		-------------------------------------------------------------------- */
		$wp_roles->remove_cap( 'administrator', 'manage_links' );
		$wp_roles->remove_cap( 'administrator', 'edit_plugins' );

		/* --------------------------------------------------------------------
		:: Editor
		-------------------------------------------------------------------- */
		$wp_roles->add_cap( 'editor', 'edit_theme_options' );
		$wp_roles->remove_cap( 'editor', 'manage_links' );

	}
}


?>