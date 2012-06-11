<?php
/************************************************************
**                              
** TinyMCE Custom Styles                                        
**                                     
*************************************************************

This module allows you to apply custom styles to the TinyMCE editor's Visual editing mode.

You can use this to help make the content in the editor more closely resemble how it will look on the live webpage.  

/* --------------------------------------------------------------------
Apply Theme Stylesheet to the TinyMCE Editor
-------------------------------------------------------------------- */
// Function finds the specified stylesheet from the root of the current theme's folder.
add_editor_style('style.css');

// You could also create and use a separate stylesheet specifically for the editor, like the example below
//add_editor_style('css/my-custom-tinymce.css');

?>