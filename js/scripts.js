/******************************************************************
Global Site Scripts 


IMPORTANT:  Only use this file to for scripts that must be enabled
on ALL pages of the site.  

For scripts specific to particular pages or sections, use a new
.js file and register/enqueue in functions.php for only the
required pages.

http://codex.wordpress.org/Function_Reference/wp_register_script
http://codex.wordpress.org/Function_Reference/wp_enqueue_script

******************************************************************/

// Modernizr.load loading the right scripts only if you need them
Modernizr.load([
	{
    // Let's see if we need to load selectivizr
    test : Modernizr.borderradius,
    // Modernizr.load loads selectivizr and Respond.js for IE6-8
    nope : ['libs/selectivizr-min.js']
	}
]); /* end Modernizr load script */

// jQuery Scripts
jQuery(document).ready(function($) {
	
	// Add your jQuery scripts here
	
	//$('html').addClass('jquery-enabled'); // For example only.  Can be removed.

}); /* end of jQuery Scripts */