<?php
/**
 * Admin Menu Customization 
 */

/**
 * Removes tabs from the Admin menu
 *
 * NOTE: This function will NOT disable access to the features themselves.
 * 
 * If you want to completely prevent users from accessing certain admin
 * features, see: /includes/user-capabilities.php
 *
 * @uses remove_menu_page()
 */
function gs_remove_admin_menus(){
    if ( function_exists('remove_menu_page') ) { 

		/**
		 * Removes the Tools tab for all users below Admin
		 */
    	if ( !current_user_can('remove_users') ) {
        remove_menu_page('tools.php');  
    	}

    }
}
add_action('admin_menu', 'gs_remove_admin_menus'); 


/**
 * Customizes the order of the admin menu tabs
 */
function gs_custom_menu_order($menu_ord) {
		if (!$menu_ord) return true;
		return array(
			'index.php',
			'separator1',
			'edit.php?post_type=page',
			'edit.php',
		);

	/* -- DEFAULTS -- */

		/*
		return array(
			'index.php',
			'separator1',
			'edit.php?post_type=page', 
			'edit.php', 
			'edit.php?post_type=[your_post_type_slug]',
			'upload.php',
			'link-manager.php',
			'edit-comments.php',
			'separator2',
			'themes.php',
			'plugins.php',
			'users.php',
			'tools.php',
			'options-general.php'
		);
		*/
}
add_filter('custom_menu_order', 'gs_custom_menu_order');
add_filter('menu_order', 'gs_custom_menu_order');