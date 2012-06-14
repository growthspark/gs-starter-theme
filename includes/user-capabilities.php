<?php
/*********************************************************************
**                              
** Custom User Capabilities                                    
** 
** For full list of capabilities, see:
** http://codex.wordpress.org/Roles_and_Capabilities  
**                                
**********************************************************************/

global $wp_roles;

if (class_exists('WP_Roles'))
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();	

if (is_object($wp_roles)) {


	/* --------------------------------------------------------------------
	:: Administrator
	-------------------------------------------------------------------- */
	$wp_roles->remove_cap( 'administrator', 'manage_links' );


	/* --------------------------------------------------------------------
	:: Editor
	-------------------------------------------------------------------- */
	$wp_roles->remove_cap( 'editor', 'manage_links' );
	$wp_roles->add_cap( 'editor', 'edit_theme_options' );
	

}




?>