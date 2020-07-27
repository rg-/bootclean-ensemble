<?php

/*

	Show helpers on fields on admin, that is
	front end function to get the field like 

*/

add_filter('wpbc/filter/theme_settigs/show_helpers', '__return_false');


/*

	Remove tabs and fields from Theme Settings Groups

	Defaults are:

			'fields-general',
			'fields-header',
			'fields-footer', 
			'fields-custom-code',

*/ 

add_filter('wpbc/filter/theme_settings/file_path', function($file_path, $key){

	$excluded_groups = array(
		'fields-header', 
		'fields-footer',
	);

	if( in_array($key, $excluded_groups) ){
		$file_path = '';
	}

	return $file_path;

},10,2);


/*

	Filter arguments for option page and default group

*/

add_filter('wpbc/filter/theme_settings/args',function($args){
	$args['options_page']['page_title'] = 'Ensemble settings';
	$args['options_page']['menu_title'] = 'Ensemble settings';
	$args['options_page']['icon_url'] = '';
	return $args;
},11,1);



/*

	Adding fields into settings

*/


add_filter('wpbc/filter/theme_settings/fields/general', 'WPBC_child_custom_theme_settings__footer', 10, 1); 

function WPBC_child_custom_theme_settings__footer($fields){ 

	$fields[] =  WPBC_acf_make_post_object_wpcf7_field(
		array( 
			'name' => 'footer_form',
			'label' => _x('Contact form','ensemble'),  
		)
	);

	$fields[] =  WPBC_acf_make_url_field(
		array( 
			'name' => 'footer_youtube',
			'label' => _x('Link a Youtube','ensemble'),  
		)
	);


	$Sub_fields_footer_descargas = array();
		$Sub_fields_footer_descargas[] = WPBC_acf_make_select_field(
			array(
				'name'=> 'descargas_return_type',
				'label'=>'Método', 
				'choices' => array (
					'auto' => 'Automático',
					'custom' => 'Customizado',
				),
				'default_value' => 'auto',
				'width' => '20%',
			)
		);

		$Sub_fields_footer_descargas[] = WPBC_acf_make_radio_field(
			array(
				'name'=> 'descargas_return_orderby',
				'label'=>'Ordenar por', 
				'choices' => array (
					'menu_order' => 'Orden de la Unidad (menu_order)',
					'title' => 'Título',
					'rand' => 'Ordenar al azar',
				),
				'default_value' => 'menu_order',
				'width' => '80%',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_descargas_return_type',
							'operator' => '==',
							'value' => 'auto',
						),
					), 
				),
			)
		);

		$Sub_fields_footer_descargas[] = WPBC_acf_make_relationship_field(
			array(
				'name'=> 'descargas_return_custom',
				'label'=>'Seleccionar las Unidades a mostrar',
				'post_type' => array('unidad'),
				'width' => '100%',
				'return_format' => 'id',
				'instructions' => 'El link de descarga será el seleccionado en cada Unidad (Ver Unidad Link)',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_descargas_return_type',
							'operator' => '==',
							'value' => 'custom',
						),
					), 
				),
			)
		);

	$fields[] = WPBC_acf_make_group(
		array(
			'name'=> 'footer_descargas',
			'label'=>'Descargas a mostrar', 
			'sub_fields' => $Sub_fields_footer_descargas
		)
	);

	$fields[] =  WPBC_acf_make_gallery_advanced_field(
		array( 
			'name' => 'footer_logos',
			'label' => _x('Logos al pié','ensemble'),  
			'button_label' => 'Agregar imágen',
			'class' => 'acf-small-gallery acf-inverted-gallery',
			'columns' => 6,
			'preview_size' => 'thumbnail'
		)
	);

	return $fields;
}