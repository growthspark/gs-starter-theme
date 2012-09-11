<?php
/**
 * Admin Branding
 *
 * This file contains functions for branding various areas of
 * the WordPress admin panels with custom logos.
 */

/**
 * Adds a custom logo to the login screen
 *
 * @uses growthspark_get_default_logo_options()
 * @uses get_option()
 */
function gs_custom_login_logo() {
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
add_action('login_head', 'gs_custom_login_logo');


/**
 * Change login logo URL
 *
 * Changes the link on the login logo to the site's own URL, instead 
 * of WordPress.org.
 */
function gs_custom_login_url() {
  return site_url();
}
add_filter( 'login_headerurl', 'gs_custom_login_url', 10, 4 );


/**
 * Adds a custom logo to the Dashboard
 *
 * @uses growthspark_get_default_logo_options()
 * @uses get_option()
 */
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
add_action('admin_head', 'gs_add_logo_to_dashboard');