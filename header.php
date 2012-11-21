<!DOCTYPE html><!--[if lt IE 7]> <html class="lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie10 lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie10 lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->


<head>

<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">


<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

<!-- BEGIN head functions -->
<?php wp_head(); ?>
<!-- END head functions -->

</head>


<body <?php body_class(); ?> >

	<div id="page-container">
		<header id="page-header" role="banner">
			<div class="row header-row">
				<div class="logo-container four columns no-border">

					<a href="<?php bloginfo('url'); ?>" class="logo ir" style="background:no-repeat url(<?php bloginfo('template_url') ?>/img/logo.png);background-size: 216px 80px; height:80px;width: 216px;">
						<?php bloginfo('name'); ?>
					</a>
				</div>
				<div class="eight columns nav-container no-border">
					<nav class="header-nav" role="navigation">
						<?php wp_nav_menu( 
							array(  'sort_column' => 'menu_order', 
									'theme_location' => 'main', 
									'menu_class' => 'nav-links clearfix',
									'container' => 'false') 
									); ?>
					</nav>
				</div>
			</div>
		</header>

		<div id="page-content" role="main">
        
<!--END HEADER-->