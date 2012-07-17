<?
/**********************************************************************
**                              
** TinyMCE Editor Customization                                          
**   
** Contents
** I. Add Theme Styles to Editor
** II. Customize First Row Icons
** III. Customize Second Row Icons
** IV. Customize Format Types Menu
**                                                
**********************************************************************/

/* --------------------------------------------------------------------

I. Apply Theme Stylesheet to the TinyMCE Editor

-------------------------------------------------------------------- */
// Function finds the specified stylesheet from the root of the current theme's folder.
add_editor_style('css/web-fonts.css');
add_editor_style('css/base.css');
add_editor_style('style.css');


/* --------------------------------------------------------------------

II. Customize First Row Icons

** Based on code by Kevin Leary 
** http://www.kevinleary.net/customizing-tinymce-wysiwyg-editor-wordpress/  

-------------------------------------------------------------------- */
if( !function_exists('gs_custom_mce_buttons') ){
	function gs_custom_mce_buttons($buttons) {

		/* 
		Sets the first row of buttons.  Specify your desired buttons in the following array.

		A full list of available buttons can be found here:
		http://www.tinymce.com/wiki.php/Buttons/controls 
		*/

		return array(
			'formatselect', 
			'bold', 
			'italic', 
			'underline',
			'bullist', 
			'numlist', 
			'blockquote', 
			'removeformat', 
			'spellchecker', 
			'link', 
			'unlink', 
			'wp_more', 
			'undo', 
			'redo',
			'fullscreen', 
			'wp_help'
		);

		/* 

		WordPress first row defaults:

		return array(
			'bold', 
			'italic', 
			'strikethrough', 
			'separator', 
			'bullist', 
			'numlist', 
			'blockquote', 
			'separator', 
			'justifyleft', 
			'justifycenter', 
			'justifyright', 
			'separator', 
			'link', 
			'unlink', 
			'wp_more', 
			'separator', 
			'spellchecker', 
			'fullscreen', 
			'wp_adv'
		); 

		*/

	}
	add_filter('mce_buttons', 'gs_custom_mce_buttons', 0);
}

/* --------------------------------------------------------------------

III. Customize Second Row Icons

-------------------------------------------------------------------- */
if( !function_exists('gs_custom_mce_buttons_2') ){
	function gs_custom_mce_buttons_2($buttons) {
		/* 

		Sets the second row of buttons.  Specify your desired buttons in the following array.

		A full list of available buttons can be found here:
		http://www.tinymce.com/wiki.php/Buttons/controls 

		*/

		return array();  

		/* 

		WordPress second row defaults:

		return array(
			'formatselect', 
			'underline', 
			'justifyfull', 
			'forecolor', 
			'separator', 
			'pastetext', 
			'pasteword', 
			'removeformat', 
			'separator', 
			'media', 
			'charmap', 
			'separator', 
			'outdent', 
			'indent', 
			'separator', 
			'undo', 
			'redo', 
			'wp_help'
		); 

		*/
	
	}
}
add_filter('mce_buttons_2', 'gs_custom_mce_buttons_2', 0);

/* --------------------------------------------------------------------
IV. Customize Format Types Menu

Documentation: 
http://www.tinymce.com/wiki.php/Configuration:theme_advanced_blockformats
-------------------------------------------------------------------- */
if( !function_exists('gs_custom_mce_format') ){
	function gs_custom_mce_format($init) {
		// Add block format elements you want to show in dropdown
		$init['theme_advanced_blockformats'] = 'p,h2,h3,h4';

		/* Include WordPress Defaults */
		//$init['theme_advanced_blockformats'] = 'p,address,pre,h1,h2,h3,h4,h5,h6';
		
		/* Include All Available Formats:*/	
		//$init['theme_advanced_blockformats'] = 'p,div,h1,h2,h3,h4,h5,h6,blockquote,dt,dd,code,samp';
			
		return $init;
	}
	add_filter('tiny_mce_before_init', 'gs_custom_mce_format' );
}
 ?>