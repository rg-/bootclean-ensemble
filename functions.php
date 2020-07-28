<?php
/* ################################################################################## */
/* ################################################################################## */
/**
 * Bootclean child custom functions
 *
 * @package Bootclean
 * @subpackage Child Theme
 * 
 */
/* ################################################################################## */
/* ################################################################################## */

/**
 * @subpackage Enable "theme_settings" options pages
 */

	add_filter('wpbc/filter/theme_settings/installed', '__return_true');
		
		/* Customs for theme settings here */
		
		include('functions/addon-theme_settings.php');

/* ################################################################################## */

/**
 * @subpackage Enable "swup" addon
 */

	// add_filter('wpbc/filter/swup/installed', '__return_true');
	// include('functions/addon-swup.php');

/* ################################################################################## */

/**
 * @subpackage Enable "private_areas" addon
 */

	// add_filter('wpbc/filter/private_areas/installed', '__return_true');
	// include('functions/addon-private_areas.php');

/* ################################################################################## */

/**
 * @subpackage "theme-*" customs
 */

	include('functions/theme-textdomain.php'); 
	include('functions/theme-options.php');
	include('functions/theme-users.php');
	include('functions/theme-login.php'); 
	// include('functions/theme-options-page-settings.php');
	include('functions/theme-scripts.php');
	include('functions/theme-fonts.php');
	// include('functions/theme-widgets.php');

/* ################################################################################## */

/* core */
// include('functions/core-theme_support.php'); 

/* ################################################################################## */

/* front-end layout */ 
include('functions/layout.php');
include('functions/layout-modal.php');
include('functions/layout-navmenus.php');

/* ################################################################################## */

/**
 * @subpackage WooCommerce
 */
if( class_exists( 'WooCommerce' ) ){
	include('functions/plugins-woocommerce.php');
}

/* ################################################################################## */

include('functions/template-landing.php');

/* ################################################################################## */

include('functions/post_type-unidades.php');
include('functions/post_type-autores.php');

/* ################################################################################## */


/* ################################################################################## */