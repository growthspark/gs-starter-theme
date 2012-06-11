<?php
/*********************************************************************
**                              
** Custom User Capabilities                                    
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
	$wp_roles->add_cap( 'editor', 'edit_theme_options' );
	$wp_roles->remove_cap( 'editor', 'manage_links' );

}

/* --------------------------------------------------------------------

:: Hide Admin Tabs

Can be used as a work-around to hide tabs from the admin menu
when modifying capabilities isn't an option.

-------------------------------------------------------------------- */
function gs_remove_admin_menus(){

    if ( function_exists('remove_menu_page') ) { 

    	// Remove the Tools tab for all users below Admin
    	if ( !current_user_can('remove_users') ) {
        remove_menu_page('tools.php');  
    	}

    }

}
add_action('admin_menu', 'gs_remove_admin_menus'); 



?>