<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="utf-8">

	<?php // force Internet Explorer to use the latest rendering engine available ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title(' : '); ?></title>

	<?php // mobile meta (hooray!) ?>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
	<![endif]-->
	<?php // or, set /favicon.ico for IE10 win ?>
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
        <meta name="theme-color" content="#121212">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php // wordpress head functions ?>
	<?php wp_head(); ?>
	<?php // end of wordpress head ?>

	<?php // drop Google Analytics Here ?>
	<?php // end analytics ?>

</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

	
	<div class="body-wrapper">
	<!-- ********************************************************************* -->
	<!--****************** Site header ***************************************-->
	<!-- ********************************************************************* -->

	<header class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div class="header-inner">

				<div class="top-bar">
					<section class="layout">
						<div class="top-contact-info">
							<ul>
								<li><i class="fa fa-phone"></i><span>88245608 - 22342660</span></li>
								<li><i class="fa fa-envelope"></i><span> info@gsalborz.com </span></li>
								<li class="current-time">
									<i class="fa fa-calendar"></i>
								<?php if(ICL_LANGUAGE_CODE == 'en') {
									echo date(' Y-m-d  H:i ', current_time('timestamp', 1));
								}else {
									if (function_exists('jdate')) {
										echo jdate(' Y-m-d  H:i ', current_time('timestamp', 0));
									} else {
										echo date(' Y-m-d  H:i ', current_time('timestamp', 1));
									}
								}

								?>

							</li>
							</ul>
						</div>
						<div class="lang-container">
							<?php
								if(function_exists('icl_language_selector')) {
									do_action('icl_language_selector');
								}
							?>
						</div>
					</section>
				</div><!--top-bar-->

				<div class="hero">
					<section class="layout">
						<div class="site-logo-container">
							<?php if(is_rtl()){?>
								<img class="site-logo" src="<?php echo get_template_directory_uri();?>/images/gsalborz-logo-fa-300.png" alt="<?php echo get_bloginfo('url'); ?>"/>
							<?php } else { ?>
								<img class="site-logo" src="<?php echo get_template_directory_uri();?>/images/gsalborz-logo-en-300.png" alt="<?php echo get_bloginfo('url'); ?>"/>
							<?php } ?>
						</div>

						<span class="menu-toggler" id="menu-toggler">
							<i class="fa fa-bars"></i>
						</span>

						<div class="menu-search-area">
							<?php echo gsalborz_menu_search_form(); ?>
						</div>
					</section>
				</div><!-- hero -->
			

				<nav role="navigation" class="main-menu" itemscope="" itemtype="http://schema.org/SiteNavigationElement">
					<section class="layout">
						<?php $walker = new Menu_With_Image();?>
						<?php wp_nav_menu(array(
								 'container' => false,                           // remove nav container
								 'container_class' => 'menu cf',                 // class of container (should you choose to use it)
								 'menu' => __( 'Main Menu', 'gsalborz' ),  // nav name
								 'menu_class' => 'nav main-nav cf',
								  'walker' => $walker,             // adding custom nav class
								 'theme_location' => 'main-menu',                 // where it's located in the theme
								 'before' => '',                                 // before the menu
								   'after' => '',                                  // after the menu
								   'link_before' => '',                            // before each link
								   'link_after' => '',                             // after each link
								   'depth' => 3,                                   // limit the depth of the nav
								 'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>
					</section>
				</nav><!--main-menu-->

				<div class="banner-container">
					<section class="layout">
						<?php echo get_template_part("library/banner","maker"); ?>
					</section>
				</div><!--banner-container-->

			</div><!--header-inner-->

	</header><!--site-header-->

<!-- ********************************************************************* -->
<!--****************** Site Main ******************************************-->
<!-- ********************************************************************* -->

