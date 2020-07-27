<?php

include('template-landing/functions.php');


/*

	Disable section helper (key field) on admin

*/

add_filter('wpbc/filter/template-landing/fields/show_helper','__return_false',10,1);

/*

	Template Landing custom child settings

*/ 


add_filter('wpbc/filter/layout/main-navbar/defaults', 'wpbc_child_main_navbar_template_landing',10,1);
function wpbc_child_main_navbar_template_landing($args){
	if(is_page_template('_template_landing_builder.php')){
		// $args['affix'] = true; 
		// $args['affix_defaults']['simulate'] = false;
	}
	return $args;
}


add_filter('wpbc/filter/template-landing/default_section', function($default_section){

	$default_section['acf']['label'] = 'Portada de página';
	$default_section['acf']['group_layout'] = 'block';

	return $default_section;
},10,1 );

/*

	Wrap sections into DIV

*/

add_action('wpbc/layout/sections/start', function($sections, $is_page_header){
	if(!$is_page_header) echo "<div id='sections-wrapper'>";
},0,2);
add_action('wpbc/layout/sections/end', function($sections, $is_page_header){
	if(!$is_page_header) echo "</div>";
},0,2);


/*

	Add new section, needs template-parts/template-landing/section-1.php file

*/

function WPBC_child_get_sections($sections = array()){ 
	
	$comp_layouts_icon = ''; 

	$sec_arr = array(
		array(
			'slug' => 'unidades',
			'label' => 'Unidades'
		),
		array(
			'slug' => 'como-funciona',
			'label' => 'Funcionamiento'
		),
		array(
			'slug' => 'tipos-de-contenidos',
			'label' => 'Contenidos'
		),
		array(
			'slug' => 'palabras-de-los-autores',
			'label' => 'Autores',
			'class' => 'bg-light',
		),
		array(
			'slug' => 'conoce-mas',
			'label' => 'Conocé más'
		),
	);

	foreach($sec_arr as $key=>$value){
		$def_section_class = 'gpy-4 gpy-md-2';
		if(!empty($value['class'])){
			$section_class = $def_section_class.' '.$value['class'];
		}else{
			$section_class = $def_section_class;
		}
		$sections[] = array(
			'id' => $value['slug'],
			'attrs'=>'',
			'class' => 'template-landing--'.$value['slug'].' '.$section_class,
			'acf' => array(
				'group_id' => 'section-'.$value['slug'],
				'group_layout' => 'block', 
				'label' => $comp_layouts_icon.$value['label'],
				'sub_fields' => array(),
			),
		);
	} 
	return $sections;
}

add_filter('wpbc/filter/template-landing/build_sections', function($build_sections){

	$build_sections = WPBC_child_get_sections($build_sections);

	return $build_sections;
},10,1);


/*
	
	Add fields into existing sectinons by group_id.

*/

add_filter('wpbc/filter/template-landing/sub_fields/?group=page_header', function($sub_fields){ 

	$sub_fields[] = WPBC_acf_make_textarea_field(
		array(
			'name'=> 'title_header',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	);

	$sub_fields[] = WPBC_acf_make_wysiwyg_field(
		array(
			'name'=> 'col_wysiwyg',
			'label'=>'Texto descriptivo',  
		)
	);  

	$sub_fields[] = WPBC_acf_make_gallery_advanced_field(
		array(
			'name' => 'page_header_logos',
			'label'=>'Logos', 
			'class' => 'acf-small-gallery acf-inverted-gallery',
			'columns' => 6,
		)
	);

	$sub_fields[] = WPBC_acf_make_gallery_advanced_field(
		array(
			'name' => 'page_header_gallery',
			'label'=>'Slide de imágenes',
			'class' => 'acf-small-gallery', 
			'columns' => 6,
		)
	);

	return $sub_fields;
},10,1);


add_filter('wpbc/filter/template-landing/sub_fields/?group=section-unidades', function($sub_fields){
	$sub_fields[] = WPBC_acf_make_text_field(
		array(
			'name'=> 'title',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	);
	$sub_fields[] = WPBC_acf_make_textarea_field(
		array(
			'name'=> 'destacado',
			'label'=>'Texto destacado',
			'class'=>'',
		)
	);


	$Sub_fields_unidades_return = array();

		$Sub_fields_unidades_return[] = WPBC_acf_make_select_field(
			array(
				'name'=> 'unidades_return_type',
				'label'=>'Método', 
				'choices' => array (
					'auto' => 'Automático',
					'custom' => 'Customizado',
				),
				'default_value' => 'auto',
				'width' => '20%',
			)
		);

		$Sub_fields_unidades_return[] = WPBC_acf_make_radio_field(
			array(
				'name'=> 'unidades_return_orderby',
				'label'=>'Ordenar por', 
				'choices' => array (
					'menu_order' => 'Orden de la entrada (menu_order)',
					'title' => 'Título',
					'rand' => 'Ordenar al azar',
				),
				'default_value' => 'menu_order',
				'width' => '80%',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_unidades_return_type',
							'operator' => '==',
							'value' => 'auto',
						),
					), 
				),
			)
		);

		$Sub_fields_unidades_return[] = WPBC_acf_make_relationship_field(
			array(
				'name'=> 'unidades_return_custom',
				'label'=>'Seleccionar las entradas a mostrar',
				'post_type' => array('unidad'),
				'width' => '100%',
				'return_format' => 'id',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_unidades_return_type',
							'operator' => '==',
							'value' => 'custom',
						),
					), 
				),
			)
		);

	$sub_fields[] = WPBC_acf_make_group(
		array(
			'name'=> 'unidades_return',
			'label'=>'Unidades a mostrar', 
			'sub_fields' => $Sub_fields_unidades_return
		)
	);

	

	return $sub_fields;
},10,1);

add_filter('wpbc/filter/template-landing/sub_fields/?group=section-como-funciona', function($sub_fields){
	
	$sub_fields[] = WPBC_acf_make_text_field(
		array(
			'name'=> 'title',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	);

	$sub_fields_items = array();

		$sub_fields_items[] = WPBC_acf_make_image_field(
			array(
				'name'=> 'item_image',
				'label'=>'Imagen', 
			)
		);

		$sub_fields_items[] = WPBC_acf_make_text_field(
			array(
				'name'=> 'item_title',
				'label'=>'Título',
				'class'=>'acf-input-title',
			)
		);

		$sub_fields_items[] = WPBC_acf_make_textarea_field(
			array(
				'name'=> 'item_text',
				'label'=>'Descripción',
				'class'=>'',
			)
		);

	$sub_fields[] = WPBC_acf_make_repeater_field(
		array(
			'name'=> 'items',
			'label'=>'Items/Bloques',
			'sub_fields'=> $sub_fields_items,
			'button_label' => 'Agregar Item',
		)
	);

	return $sub_fields;
},10,1);

add_filter('wpbc/filter/template-landing/sub_fields/?group=section-tipos-de-contenidos', function($sub_fields){
	$sub_fields[] = WPBC_acf_make_text_field(
		array(
			'name'=> 'title',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	);
	$sub_fields_items = array();

		$sub_fields_items[] = WPBC_acf_make_image_field(
			array(
				'name'=> 'item_image',
				'label'=>'Imagen', 
			)
		);

		$sub_fields_items[] = WPBC_acf_make_text_field(
			array(
				'name'=> 'item_title',
				'label'=>'Título',
				'class'=>'acf-input-title',
			)
		);

		$sub_fields_items[] = WPBC_acf_make_textarea_field(
			array(
				'name'=> 'item_text',
				'label'=>'Descripción',
				'class'=>'',
			)
		);

	$sub_fields[] = WPBC_acf_make_repeater_field(
		array(
			'name'=> 'items',
			'label'=>'Items/Bloques',
			'sub_fields'=> $sub_fields_items,
			'button_label' => 'Agregar Item',
		)
	);
	return $sub_fields;
},10,1);

add_filter('wpbc/filter/template-landing/sub_fields/?group=section-palabras-de-los-autores', function($sub_fields){
	$sub_fields[] = WPBC_acf_make_text_field(
		array(
			'name'=> 'title',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	); 
	$sub_fields[] = WPBC_acf_make_wysiwyg_field(
		array(
			'name'=> 'col_1_text',
			'label'=>'Texto columna izquierda', 
			'width' => '50%',
		)
	); 
	$sub_fields[] = WPBC_acf_make_wysiwyg_field(
		array(
			'name'=> 'col_2_text',
			'label'=>'Texto columna derecha', 
			'width' => '50%',
		)
	); 


	$Sub_fields_unidades_return = array();

		$Sub_fields_unidades_return[] = WPBC_acf_make_select_field(
			array(
				'name'=> 'autores_return_type',
				'label'=>'Método', 
				'choices' => array (
					'auto' => 'Automático',
					'custom' => 'Customizado',
				),
				'default_value' => 'auto',
				'width' => '20%',
			)
		);

		$Sub_fields_unidades_return[] = WPBC_acf_make_radio_field(
			array(
				'name'=> 'autores_return_orderby',
				'label'=>'Ordenar por', 
				'choices' => array (
					'menu_order' => 'Orden de la entrada (menu_order)',
					'title' => 'Título',
					'rand' => 'Ordenar al azar',
				),
				'default_value' => 'menu_order',
				'width' => '80%',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_autores_return_type',
							'operator' => '==',
							'value' => 'auto',
						),
					), 
				),
			)
		);

		$Sub_fields_unidades_return[] = WPBC_acf_make_relationship_field(
			array(
				'name'=> 'autores_return_custom',
				'label'=>'Seleccionar las entradas a mostrar',
				'post_type' => array('autor'),
				'width' => '100%',
				'return_format' => 'id',
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_autores_return_type',
							'operator' => '==',
							'value' => 'custom',
						),
					), 
				),
			)
		);

	$sub_fields[] = WPBC_acf_make_group(
		array(
			'name'=> 'autores_return',
			'label'=>'Autores/autoras a mostrar', 
			'sub_fields' => $Sub_fields_unidades_return
		)
	);


	return $sub_fields;
},10,1);

add_filter('wpbc/filter/template-landing/sub_fields/?group=section-conoce-mas', function($sub_fields){
	$sub_fields[] = WPBC_acf_make_text_field(
		array(
			'name'=> 'title',
			'label'=>'Título de sección',
			'class'=>'acf-input-title',
		)
	); 

	$sub_fields[] = WPBC_acf_make_image_field(
			array(
				'name'=> 'image',
				'label'=>'Imagen', 
			)
		);

	$sub_fields[] = WPBC_acf_make_wysiwyg_field(
		array(
			'name'=> 'col_wysiwyg',
			'label'=>'Texto descriptivo',  
		)
	); 
	return $sub_fields;
},10,1);






/*

	Some custom functions

*/





function __get_social_icon($args=array(),$content=null,$tag){
	$defs = array();  
	if(empty($args)){
		$args = array();
	} 
  $args = array_merge($defs, $args); 
	$fill = !empty($args['fill']) ? $args['fill'] : '#000000';
	$width = '24px';
	$width = !empty($args['xs']) ? '16px' : $width;
	$width = !empty($args['sm']) ? '18px' : $width;
	$class = '';

	if($tag=='icon_youtube'){
		$icon = '<svg class="'.$class.'" style="width:'.$width.';height:auto;" x="0px" y="0px" width="40px" height="28.3px" viewBox="0 0 40 28.3" xml:space="preserve"><path fill="'.$fill.'" d="M31.7,0H8.3C3.8,0,0,3.7,0,8.3V20c0,4.5,3.7,8.3,8.3,8.3h23.4c4.5,0,8.3-3.7,8.3-8.3V8.3C39.9,3.7,36.2,0,31.7,0
	 M26.3,14.899l-11.6,5.5c-0.3,0.101-0.6-0.1-0.6-0.5V8.5c0-0.4,0.4-0.6,0.6-0.5l11.6,5.8C26.6,14.1,26.6,14.6,26.3,14.899"/></svg>';
	}

	return $icon;
}
	
function __get_icon($args=array(),$content=null,$tag){
	$defs = array();  
	if(empty($args)){
		$args = array();
	} 
  $args = array_merge($defs, $args); 
	$fill = !empty($args['fill']) ? $args['fill'] : '#000000';
	$width = '24px';
	$width = !empty($args['xs']) ? '16px' : $width;
	$width = !empty($args['sm']) ? '18px' : $width;
	$class = '';
	if($tag=='icon_arrow_left'){
		$class = 'rotate-90';
	}
	if($tag=='icon_arrow_right'){
		$class = 'rotate--90';
	}
	if($tag=='icon_arrow_up'){
		$class = 'rotate-180';
	}
	if($tag=='icon_arrow_down'){
		 
	}
	$icon = '<svg class="'.$class.'" style="width:'.$width.';height:auto;" x="0px" y="0px"
	 width="18.636px" height="19.254px" viewBox="0 0 18.636 19.254"
	 xml:space="preserve">
<path fill="'.$fill.'" d="M18.292,7.942c-0.416-0.362-1.048-0.321-1.41,0.098l-6.563,7.541V1c0-0.552-0.447-1-1-1c-0.552,0-1,0.448-1,1v14.583
	L1.754,8.04C1.391,7.623,0.76,7.58,0.344,7.942c-0.417,0.363-0.46,0.994-0.098,1.411l8.317,9.558
	c0.008,0.009,0.02,0.012,0.028,0.021C8.655,19,8.735,19.051,8.816,19.1c0.035,0.021,0.063,0.051,0.101,0.067
	c0.119,0.053,0.249,0.082,0.388,0.084c0.004,0,0.008,0.003,0.013,0.003c0,0,0,0,0.001,0l0,0c0.144,0,0.279-0.033,0.402-0.088
	c0.028-0.012,0.049-0.035,0.076-0.051c0.093-0.052,0.18-0.11,0.252-0.188c0.006-0.007,0.016-0.009,0.022-0.017l8.318-9.558
	C18.753,8.936,18.709,8.305,18.292,7.942z"/>
</svg>';
	 
	return $icon;
}
add_shortcode('icon_arrow_left','__get_icon');
add_shortcode('icon_arrow_right','__get_icon');
add_shortcode('icon_arrow_up','__get_icon');
add_shortcode('icon_arrow_down','__get_icon');
add_shortcode('icon_youtube','__get_social_icon');

function WPBC_template_landing_next_section($next){
	if(!empty($next)){
	?>
	<p data-is-inview="detect" <?php WPBC_make_is_inview_fadeInUp_attrs(array(
		'delay' => '.98s',
		'class' => 'text-center gpt-2'
	)); ?>><a href="#<?php echo $next; ?>" class="btn btn-next scroll-to" data-btn="fx" data-fx="down">[icon_arrow_down]</a></p>
	<?php
	}
}