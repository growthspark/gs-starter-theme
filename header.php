<!DOCTYPE html> 

<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->


<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
    
    
	<!-- icons & favicons -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">

    <!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end wordpress head functions -->

</head>


<body <?php body_class(); ?> >


	<div id="pageContainer">
		<header id="pageHeader">
				<div id="logo">
					<a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/img/gs-logo.png"></a>
				</div>
				<nav>
					<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'theme_location' => 'main', 'fallback_cb' => '',) ); ?>
				</nav>
		</header>
        
        <div id="pageContent" role="main">
        
<!--END HEADER-->