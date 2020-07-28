<?php

add_filter('wpbc/filter/custom_login/enable','__return_true');

add_filter('wpbc/filter/custom_login/args', function($args){

	$args['login_brand'] = array(
		'background-image' => get_stylesheet_directory_uri().'/images/theme/logo-ensemble-@x2.png',
		'background-size' => '300px auto',
		'width' => '300px',
		'height' => '70px',
	);

	return $args;

}); 