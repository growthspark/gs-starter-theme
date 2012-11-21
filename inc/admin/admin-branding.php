<?php

/**
 * Admin Branding
 *
 * This class adds a custom logo to the dashboard & login screen of WordPress.
 *
 */
class GS_Admin_Branding {

    private $logo_path;
    private $logo_width;
    private $logo_height;

    function __construct() {

        $this->logo_path = get_bloginfo('template_url') . '/img/logo.png';
        $this->logo_width = 216;
        $this->logo_height = 80;

        add_action('login_head', array($this, 'login_logo'));
        add_filter('login_headerurl', array($this, 'login_url'), 10, 4);
        add_action('admin_head', array($this, 'dashboard_logo'));
    }

    /**
     * Adds a custom logo to the login screen
     */
    function login_logo() {
        ?>
        <!-- Custom Login Logo -->
        <style type="text/css">
            .login h1 a { 
                background-image:url("<?php echo $this->logo_path; ?>") !important; 
                background-size: <?php echo $this->logo_width; ?>px <?php echo $this->logo_height ?>px !important;
                height: <?php echo $this->logo_height ?>px !important;
                width: <?php echo $this->logo_width; ?>px !important;
                padding: 0 !important;
                margin: 0 auto 20px !important;
            }
        </style>
        <!--/ Custom Login Logo -->
        <?php
    }

    /**
     * Change login logo URL
     *
     * Changes the link on the login logo to the site's own URL, instead 
     * of WordPress.org.
     */
    function login_url() {
      return site_url();
    }

    /**
     * Adds a custom logo to the Dashboard
     *
     */
    function dashboard_logo() {
        ?>
        <!-- Custom Dashboard Logo -->
        <style type="text/css">
        .index-php .wrap h2:nth-child(2) {
            visibility: hidden;
            line-height: 1px;
        }

        .index-php #icon-index {
            background-image:url("<?php echo $this->logo_path; ?>") !important; 
            background-size: <?php echo $this->logo_width; ?>px <?php echo $this->logo_height ?>px !important;
            background-position: 0px 0px !important;
            height: <?php echo $this->logo_height ?>px !important;
            width: <?php echo $this->logo_width; ?>px !important;
            float: none !important;
            margin-top: 15px !important;
        }
        </style>
        <!--/ Custom Dashboard Logo -->
        <?php
    }

}

new GS_Admin_Branding;