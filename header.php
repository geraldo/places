<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package places
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

	<?php wp_head(); ?>
	<!-- activate map.js and places.js for drawing markers from static geojson file places.js -->
	<!--<script src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/export/places.js" type="text/javascript"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/map.js" type="text/javascript"></script>-->
	<!-- activate map.php for drawing markers from wordpress post type place -->
	<script src="<?php echo get_template_directory_uri(); ?>/map.php" type="text/javascript"></script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<nav id="site-navigation" class="navigation-main" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menü', 'places' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'places' ); ?>"><?php _e( 'Skip to content', 'places' ); ?></a></div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="main" class="site-main">

	<div id="map"></div>

