<?php

/**********************************************************************

:: Remove Dashboard Widgets

Removes default widgets from the WP Dashboard.

**********************************************************************/

function gs_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	foreach($wp_meta_boxes['dashboard']['normal']['core'] as $n) {
		$nwidget = $n['id'];
		unset($wp_meta_boxes['dashboard']['normal']['core'][$nwidget]);
	}

	foreach($wp_meta_boxes['dashboard']['side']['core'] as $s) {
	$swidget = $s['id'];
	unset($wp_meta_boxes['dashboard']['side']['core'][$swidget]);
	}
}
add_action('wp_dashboard_setup', 'gs_remove_dashboard_widgets' );


?>
