<?php
/*********************************************************************
**                              
** Admin Menu Re-Ordering                                     
**                                     
***********************************************************************


/* --------------------------------------------------------------------
Set the order of the Admin menu
-------------------------------------------------------------------- */
function gs_custom_menu_order($menu_ord) {
		if (!$menu_ord) return true;
		return array(
			'index.php',
			'separator1',
			'edit.php?post_type=[your_post_type_slug]',
			'edit.php?post_type=page'
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

?>