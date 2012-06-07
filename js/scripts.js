/******************************************************************
Global Site Scripts 
******************************************************************/

/* ----------------------------------------------------------

:: Modernizr Tests

We can use Modernizr.load to load certain scripts &
libraries only when they're needed.

-------------------------------------------------------------*/

/* Support CSS Selectors in IE 6-8 */
Modernizr.load([{

		// Test for border-radius support (effectively tests for IE 6-8)
	    test : Modernizr.borderradius,
	    // Load Selectivizr to enable CSS selectors in IE 6-8
	    nope : [templateurl + '/js/selectivizr.min.js']

}]);


/* ----------------------------------------------------------

:: jQuery Scripts

Set up jQuery scripts needed on all site pages.  

-------------------------------------------------------------*/

jQuery(document).ready(function($) {

	//jQuery Scripts here

});