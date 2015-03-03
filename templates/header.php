<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<!-- Force Internet Explorer to use the latest rendering engine available -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title(); ?></title>

	<!-- Mobile meta (hooray!) -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	
	<?php wp_head(); ?>



</head>

<body <?php body_class(); ?>>

	<!--<div class="strip"></div>-->
	
	<?php if ( has_nav_menu( 'header-nav' ) ) : ?>
		<!-- Navigation -->
		<nav id="site-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<div class="logo" itemtype="http://schema.org/Organization"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"></a></div>
			<?php
				wp_nav_menu (
				array (
					'theme_location'	=> 'header-nav',
					'walker'			=> new roboaztechs_Nav_Walker,
					'container'			=> 'div',
					'container_id'		=> 'nav-container',
					'menu_class'		=> 'navigation',
					'fallback_cb'		=> false,
					)
				);
			?>
		</nav><!-- /Navigation -->
	<?php endif; ?>

	<!-- Main Content -->
	<main class="main">