<?php

/*

	Add inline head styles

*/

add_filter('WPBC_add_inline_style',function($css){
	/* On old days i use to put this on the project css file, but that will not work till the css is loaded. To prevent similar situations, just put inline styles on the most top of the <head> element, like this one here. */
	$css .= 'body.loading{overflow:hidden!important;}'; 
	$css .= '.no-touchevents ::-webkit-scrollbar { width: 10px; height: 10px; }';
	return $css;
},20,1);

/*

	Add custom js scripts on footer

*/

add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){ 
	$unique = uniqid();
	$scripts['custom'] = array(
		'src'=> CHILD_THEME_URI .'/js/custom.js?v='.$unique,
		'dependence' => array('jquery')
	);
	

	return $scripts;
},20,1);


/*
	
	ADDON is-inview

*/

function WPBC_make_is_inview_fadeInUp_attrs($args=array()){
	$class = !empty($args['class']) ? $args['class'] : '';
	$delay = !empty($args['delay']) ? $args['delay'] : '.3s';;
	echo 'data-is-inview-addclass="fadeInUp" data-is-inview-removeclass="fadeOutDown" class="animated fadeOutDown '.$class.'" data-animation-delay="'.$delay.'"';
}
function WPBC_make_is_inview_fadeInLeft_attrs($args=array()){
	$class = !empty($args['class']) ? $args['class'] : '';
	$delay = !empty($args['delay']) ? $args['delay'] : '.3s';;
	echo 'data-is-inview-addclass="fadeInLeft" data-is-inview-removeclass="fadeOutRight" class="animated fadeOutRight '.$class.'" data-animation-delay="'.$delay.'"';
}
function WPBC_make_is_inview_fadeInRight_attrs($args=array()){
	$class = !empty($args['class']) ? $args['class'] : '';
	$delay = !empty($args['delay']) ? $args['delay'] : '.3s';;
	echo 'data-is-inview-addclass="fadeInRight" data-is-inview-removeclass="fadeOutLeft" class="animated fadeOutLeft '.$class.'" data-animation-delay="'.$delay.'"';
}
 
add_filter('WPBC_enqueue_scripts__head_styles', function($styles){
	$styles['is-inview'] = array( 
		'src' => 'addons/is-inview/is-inview.css'
	);
	return $styles;
},10,1);

add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){  
	$scripts['is-inview'] = array(
		'src'=> CHILD_THEME_URI .'/addons/is-inview/is-inview.js',
		'dependence' => array('jquery')
	);
	$scripts['is-inview-lazysrc'] = array(
		'src'=> CHILD_THEME_URI .'/addons/is-inview/is-inview-lazysrc.js',
		'dependence' => array('jquery')
	);  
	return $scripts;
},10,1);


/*
	
	ADDON slick-lazy

*/
add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){  
	$scripts['slick-lazy'] = array(
		'src'=> CHILD_THEME_URI .'/addons/slick-lazy/slick-lazy.js',
		'dependence' => array('jquery')
	);  
	return $scripts;
},10,1);

/*
	
	ADDON smooth-scroll

*/
add_filter('WPBC_enqueue_scripts__footer_scripts', function($scripts){  
	$scripts['smooth-scroll'] = array(
		'src'=> THEME_URI .'/addons/smooth-scroll/SmoothScroll.min.js',
		'dependence' => array('jquery')
	);  
	return $scripts;
},10,1);