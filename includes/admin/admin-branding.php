<?php
/**********************************************************************

:: Admin Branding

Contents
I. Custom Login Logo
II. Custom Login Logo URL
III. Add Logo to Dashboard

**********************************************************************/

/* --------------------------------------------------------------------

I. Custom Login Logo

Replaces the WordPress logo on the login screen with a logo of 
your choosing.

-------------------------------------------------------------------- */
if (function_exists('get_custom_header')) {
    add_action('login_head', 'my_custom_login_logo');
    function my_custom_login_logo() {
        $defaults = growthspark_get_default_logo_options();
        $option = get_option('growthspark_logo_options', $defaults);

        ?>
        <!-- Custom Login Logo -->
        <style type="text/css">
            .login h1 a { 
            	background-image:url("<?php echo gs_get_logo(); ?>") !important; 
            	background-size: <?php echo gs_logo_width(); ?>px <?php echo gs_logo_height(); ?>px !important;
            	height: <?php echo gs_logo_height(); ?>px !important;
            	width: <?php echo gs_logo_width(); ?>px !important;
            	padding: 0 !important;
            	margin: 0 auto 20px !important;
        	}
        </style>
        <!--/ Custom Login Logo -->
        <?php
    }
}

/* --------------------------------------------------------------------

II. Custom Login Logo URL

Changes the link on the login logo to the site's own URL, instead of WordPress.org
http://primegap.net/2011/01/26/wordpress-quick-tip-custom-wp-login-php-logo-url-without-hacks/

-------------------------------------------------------------------- */
add_filter( 'login_headerurl', 'my_custom_login_url', 10, 4 );
function my_custom_login_url() {
  return site_url();
}

/* --------------------------------------------------------------------

III. Add Logo to the Dashboard

Adds a logo to the top of the Dashboard page, replacing the standard
"Dashboard" title and icon.

-------------------------------------------------------------------- */

if (function_exists('get_custom_header')) {
    add_action('admin_head', 'gs_add_logo_to_dashboard');
    function gs_add_logo_to_dashboard() {
        $defaults = growthspark_get_default_logo_options();
        $option = get_option('growthspark_logo_options', $defaults);
        ?>
        <!-- Custom Dashboard Logo -->
        <style type="text/css">
        .index-php .wrap h2:nth-child(2) {
            visibility: hidden;
            line-height: 1px;
        }

        .index-php #icon-index {
            background-image:url("<?php echo gs_get_logo(); ?>") !important; 
            background-position: 0px 0px !important;
            height: <?php echo gs_logo_height(); ?>px !important;
            width: <?php echo gs_logo_width(); ?>px !important;
            float: none !important;
            margin-top: 15px !important;
        }
        </style>
        <!--/ Custom Dashboard Logo -->
        <?php
    }
}



?>