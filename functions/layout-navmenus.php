<?php

/*

	Filter main-navbar settings

*/

add_filter('wpbc/filter/layout/main-navbar/custom_collapse', function($args){
	$args['collapse']['id'] = 'collapse-custom';
	$args['collapse']['class'] = 'bg-primary collapse-custom-right'; // collapse-custom-full, collapse-custom-full ,collapse-custom-top 
	$args['collapse']['toggler_class'] = 'toggler-white btn bg-primary gpy-1 gpx-2';
	$args['collapse']['toggler_attrs'] = ' data-btn="fx" ';
	// $args['collapse']['content'] = 'OPS';

	//$args['collapse']['before_wrapper'] = '<div class="ui-box-shadow gmy-2 ui-max-width-lg border-radius-lg">';
	//$args['collapse']['after_wrapper'] = '</div>';


	$args['collapse']['before_content'] = '<div class="gpx-md-4 gpb-2">';
	$args['collapse']['after_content'] = '</div>';

	return $args;
},10,1);
	
add_filter('wpbc/filter/layout/main-navbar/defaults', function($args){
	
	$args['class'] = 'navbar navbar-expand-xs bg-white'; 
	$args['nav_attrs'] = ' data-affix-removeclass="bg-white" data-affix-addclass="bg-primary text-white" ';

	$args['container_class'] = 'container';

	$args['navbar_brand']['class'] = 'gpy-1';
	$args['navbar_brand']['attrs'] = ' data-affix-removeclass="" data-affix-addclass="" ';  
 
	$logo = '[WPBC_get_stylesheet_directory_uri]/images/theme/logo-ensemble-@x2.png';
	$logo_alt = '[WPBC_get_stylesheet_directory_uri]/images/theme/logo-ensemble-blanco-@x2.png';
	
	$title = get_bloginfo('name');
	$args['navbar_brand']['title'] = '<img width="214" src="'.$logo.'" alt="'.$title.'" data-affix-addclass="d-none"/>';
 	$args['navbar_brand']['title'] .= '<img class="d-none" width="214" src="'.$logo_alt.'" alt="'.$title.'" data-affix-removeclass="d-none"/>';

	$args['navbar_toggler']['class'] = 'toggler-primary toggler-open-primary';
	$args['navbar_toggler']['type'] = 'animate';
	$args['navbar_toggler']['effect'] = 'cross'; 
	$args['navbar_toggler']['attrs'] = 'data-affix-addclass="toggler-white" data-affix-removeclass="toggler-primary" data-btn="fx" data-fx="left" '; 

	$args['wp_nav_menu']['container_class'] = 'collapse navbar-collapse flex-row-reverse mx-auto order-3';
	$args['wp_nav_menu']['menu_class'] = 'navbar-nav nav'; 
	
	$simulate_target = '#main-content';
	$affix = true;
	$simulate = true; 

	global $post; 
	if( WPBC_if_has_page_header($post->ID) || is_page_template('_template_landing_builder.php') ){
		$simulate = true; 
		$args['navbar_brand']['class'] .= ' scroll-to-top';
		$args['navbar_brand']['href'] = '#';

		$args['affix_defaults']['target'] = '#sections-wrapper';
		$args['affix_defaults']['offset'] = '-100px';

	}

	$args['affix'] = $affix;
	
	$args['affix_defaults']['simulate'] = $simulate;
	$args['affix_defaults']['simulate_target'] = $simulate_target;
	$args['affix_defaults']['breakpoint'] = 'xs';
	$args['affix_defaults']['scrollify'] = false;  
    
	return $args;
},30,1);   

/*
	Alter output html for menus
*/
function nav_replace_wpse_189788($item_output, $item) {  
	return $item_output; 
}
add_filter('walker_nav_menu_start_el','nav_replace_wpse_189788',10,2);


/*
	Disable main-navbar from templates
*/
add_filter('wpbc/filter/layout/main-navbar/defaults',function ($params){
	//$params['use_custom_template'] = 'none';
	return $params;
},10,1); 


/*
	Add items into menus
*/
// add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
function add_admin_link($items, $args){
    if( $args->theme_location == 'primary' ){
        $items .= '<li class="nav-item menu-item">'; 
    		$items .= 'something';
    		$items .= '</li>';
    }
    return $items;
}


/* 
	Disable dropdown markup on BootstrapNavWalker 
*/
// add_filter('nav_menu_use_dropdown',function(){ return false; });