<?php

/*

	Even WPBC detects Woocomerce and define a constant:

	 "WPBC_WOOCOMMERCE_ACTIVE" 

	 Note: on templates can use the function WPBC_is_woocommerce_active() true/false

	Customizations must be enabled like so:

*/
add_filter('wpbc/filter/woocommerce/enable_customise','__return_true',10,1); 

/*

	Modify the WPBC woocommerce main settings


	$wpbc_woocommerce_config = array(
	
		'widgets' => ....

	)

*/

add_filter('wpbc/filter/woocommerce/config', 'child_woocommerce_config',10,1);

function child_woocommerce_config($wpbc_woocommerce_config){

	/*
		Change widgets (NEVER EVER CHANGE IDS ON PRODUCTION SITE!!!!!)

		by default config has 2 woo widgets areas:

			widget_area_woocommerce
			widget_area_woocommerce_products

		You could unset one, both, add new ones, or modify args on default ones.

	*/

	//$wpbc_woocommerce_config['widgets']['widget_area_woocommerce']['name'] = 'Custom widget name here';
	//$wpbc_woocommerce_config['widgets']['widget_area_woocommerce']['description'] = 'Custom description here';


	$wpbc_woocommerce_config['layout']['shop'] = array(

		'main_container_areas_class' => 'container',
		'main_container_row_class' => 'row',
		'content_areas_cols' => array(
			'main_class' => 'col-md-9 order-2',
			'col_class' => 'col-md-3 order-1',
			'col_content' => do_shortcode('[WPBC_get_template name="layout/secondary-content" args="name:area-1"/]'),
		),
		'content_areas_single' => array(
			'main_class' => 'col-12', 
		),

	);


	$wpbc_woocommerce_config['layout']['my-account'] = array(
		'class' => 'col-navigation-md-3 col-content-md-9 col-navigation-order-1 col-content-order-2 col-navigation-order-md-1 col-content-order-md-2',
	);

	$wpbc_woocommerce_config['layout']['product'] = array(
		'class' => 'col-images-md-6 col-summary-md-6',
		'tab_class' => 'col-12',
		'upsell_class' => 'col-12',
		'related_class' => 'col-12',
	);

	return $wpbc_woocommerce_config;
}


add_filter('wpbc/filter/layout/locations', function($locations){
	if( is_account_page() ){
		$locations['page']['id'] = 'a1'; 
		$locations['page']['args']['container_type'] = 'fixed'; 
	}
	if( is_cart() || is_checkout() ){
		$locations['page']['id'] = 'a1';  
	} 
	return $locations;  
}, 20, 1 ); 

add_filter('wpbc/filter/layout/location', function($layout, $template, $using_theme_settings, $using_page_settings){
	if($template == 'page'){
		//$layout = 'a2-ml';
		if( is_account_page() || is_cart() || is_checkout() ){
			$layout = 'a1';
		}
	}
	return $layout;
},10,4);

/*

	Add a collapsable mini cart
	A button somewhere must be also inserted, like on the main navbar with cart icon and cart item count on basket....
	Or could have it´s own "open" button somewhere positioned fixed.

*/
add_action('wpbc/layout/body/end', function(){ 
	$params = array(
		'id' => 'collapse-woo-mini-cart',
		'content' => '[WPBC_woo_mini_cart]',
		'attrs' => 'style="width:480px;"',
	); 
	if(is_cart() || is_checkout()){
			
	}else{
		WPBC_get_component('collapse-custom',$params); 
	}
	 
}, 60); 

/*

	Add WooCommerce Cart Icon to Menu with Cart Item Count

*/  

/**
 * Add WooCommerce Cart Menu Item Shortcode to particular menu
 * See [WPBC_woo_cart_btn] shorcode
 */  
add_filter('wp_nav_menu_items', 'WPBC_woo_cart_btn__nav', 10, 2);
function WPBC_woo_cart_btn__nav($items, $args){
    if( $args->theme_location == 'primary' ){
        $items .=  '<li>[WPBC_woo_cart_btn]</li>'; 
    }
    return $items;
}

add_filter('wpbc/filter/woocommerce/cart_btn_link',function($args){
	$args['atts'] = 'data-toggle="collapse-custom" data-target="#collapse-woo-mini-cart" aria-expanded="false"';
	// $args['href'] = '#';
	return $args;
},10,1);




/* my-account.php */

add_filter('WPBC_post_header_show', function($show){
	if( is_account_page() ){
		$show = false;
	}
	return $show; 
},10,1);  


add_action( 'woocommerce_account_content', 'WPBC_woocommerce_account_content', 0 );
function WPBC_woocommerce_account_content(){

	if( is_wc_endpoint_url( 'orders' ) ){
		$text = __('Orders','woocommerce');
	}
	if( is_wc_endpoint_url( 'downloads' ) ){
		$text = __('Downloads','woocommerce');
	}
	if( is_wc_endpoint_url( 'edit-address' ) ){
		$text = __('Addresses','woocommerce');
	}
	if( is_wc_endpoint_url( 'edit-account' ) ){
		$text = __('Account details','woocommerce');
	}

	woocommerce_breadcrumb();
	?>
	<header class="woocommerce-products-header">
			<h1 class="woocommerce-products-header__title page-title">Mi Cuenta</h1>
	</header>
	<?php if(!empty($text)){ ?><h2 class="section-title"><?php echo $text; ?></h2><?php } ?>
	<?php
}