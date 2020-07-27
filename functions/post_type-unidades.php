<?php

/* post_type "unidad" */

add_action( 'init', 'WPBC_create_post_type__unidades' );

function WPBC_create_post_type__unidades(){
	$labels = array(
		'name' => _x('Unidades', 'ensemble'),
		'singular_name' => _x('Unidad', 'ensemble'),
		'add_new' => _x('Agregar Unidad', 'ensemble'),
		'add_new_item' => __('Nueva Unidad'),
		'edit_item' => __('Editar Unidad'),
		'new_item' => __('Nuevo Unidad'),
		'all_items' => __('Todas las Unidades'),
		'view_item' => __('Ver Unidad'),
		'search_items' => __('Buscar Unidades'),
		'not_found' =>  __('No encontrado/s'),
		'not_found_in_trash' => __('No hay Unidades'), 
		'parent_item_colon' => '',
		'menu_name' => 'Unidades', 
	);
	$args = array(
		'labels' => $labels,
		'description' => '',
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'hierarchical' => false,
		'supports' => array('title','editor','thumbnail','page-attributes'),
		'rewrite' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-book-alt', //'dashicons-welcome-learn-more',
		'menu_position' => 6,
	);
	register_post_type('unidad',$args);
}


/* ADMIN HEAD */

add_action('admin_head', function(){
	?>
<style>
	#adminmenu #menu-posts-unidad > a {
		background-color: #2c63f4!important;
	}
</style>
	<?php
});

/* ADMIN COLUMNS */ 

add_filter( 'manage_unidad_posts_columns', 'wpbc_manage_unidad_posts_columns' );  
function wpbc_manage_unidad_posts_columns( $defaults ) { 
   $defaults['featured-image'] = __('Featured Image', 'bootclean');
   return $defaults;
}
add_action( 'manage_unidad_posts_custom_column', 'wpbc_manage_unidad_posts_custom_column', 5, 2 );
function wpbc_manage_unidad_posts_custom_column( $column_name, $id ) { 
   if ( $column_name === 'featured-image' ) {
	   wpbc_get_featured_image_for_columns($id); 
   }
}


/* ACF fields */

if( function_exists('acf_add_local_field_group') ) {

	acf_add_local_field_group(array(
		'key' => 'group_unidad_detalles',
		'title' => 'Unidad detalles',
		'fields' => array(
			array(
				'key' => 'field_unidad__ver_unidad_link',
				'label' => 'Ver Unidad Link',
				'name' => 'ver_unidad_link',
				'type' => 'url',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
			),
			array(
				'key' => 'field_unidad__lecciones',
				'label' => 'Lecciones',
				'name' => 'lecciones',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'block',
				'button_label' => '',
				'sub_fields' => array(
					array(
						'key' => 'field_unidad__leccion_titulo',
						'label' => 'Título',
						'name' => 'leccion_titulo',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_unidad__leccion_link',
						'label' => 'Link',
						'name' => 'leccion_link',
						'type' => 'url',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'unidad',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'the_content',
		),
		'active' => true,
		'description' => '',
	));

}