<?php

/*

	What we are doing here?

	- Make "editor" users be able to access theme options, menus, widgets..

	- Make "editor" not be able to access themes.php or preview.php admin pages

*/

/* Add capability to user/s */ 

function azar_add_theme_caps(){
	$role_object = get_role( 'editor' );
	$role_object->add_cap( 'edit_theme_options' );
}
add_action( 'admin_init', 'azar_add_theme_caps' );

/* Remove admin menus for those user/s */ 

add_action( 'admin_menu', function() {
	// _print_code($_SERVER);
	//echo $_SERVER['SCRIPT_NAME'];
	global $current_user;
  $current_user = wp_get_current_user();
	if(current_user_can('editor')){
		remove_submenu_page( 'themes.php', 'themes.php');
		remove_submenu_page('themes.php', 'customize.php'); //Customize
	  remove_submenu_page( 'themes.php', 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI']));
  }
});