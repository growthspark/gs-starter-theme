<?php
/**********************************************************************

:: Custom Login Screen

**********************************************************************/

/* --------------------------------------------------------------------
Use a custom logo for the login screen
-------------------------------------------------------------------- */
function my_custom_login_logo() {
    ?><style type="text/css">
        h1 a { 
        	background-color: #333;
        	background-image:url('<?php header_image(); ?>') !important; 
        	background-size: <?php echo get_custom_header()->width; ?>px <?php echo get_custom_header()->height; ?>px !important;
        	height: <?php echo get_custom_header()->height; ?>px !important;
        	width: <?php echo get_custom_header()->width; ?>px !important;
        	padding: 0 !important;
        	margin: 0 auto 20px !important;
    	}
    </style>
    <?php
}
add_action('login_head', 'my_custom_login_logo');

/* --------------------------------------------------------------------

Change the link on the login logo to the site's own URL, instead of WordPress.org

http://primegap.net/2011/01/26/wordpress-quick-tip-custom-wp-login-php-logo-url-without-hacks/
-------------------------------------------------------------------- */
function my_custom_login_url() {
  return site_url();
}
add_filter( 'login_headerurl', 'my_custom_login_url', 10, 4 );


?>