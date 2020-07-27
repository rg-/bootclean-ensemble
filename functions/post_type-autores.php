<?php

/* post_type "autor" */

add_action( 'init', 'WPBC_create_post_type__autor' );

function WPBC_create_post_type__autor(){
	$labels = array(
		'name' => _x('Autores', 'ensemble'),
		'singular_name' => _x('Autor', 'ensemble'),
		'add_new' => _x('Agregar Autor', 'ensemble'),
		'add_new_item' => __('Nuevo Autor'),
		'edit_item' => __('Editar Autor'),
		'new_item' => __('Nuevo Autor'),
		'all_items' => __('Todos los Autores'),
		'view_item' => __('Ver Autor'),
		'search_items' => __('Buscar Autores'),
		'not_found' =>  __('No encontrado/s'),
		'not_found_in_trash' => __('No hay Autores'), 
		'parent_item_colon' => '',
		'menu_name' => 'Autores', 
	);
	$args = array(
		'labels' => $labels,
		'description' => '',
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'query_var' => true,
		'hierarchical' => false,
		'supports' => array('title','editor','page-attributes'),
		'rewrite' => false,
		'has_archive' => false,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'menu_position' => 6,
	);
	register_post_type('autor',$args);
}


/* ADMIN HEAD */

add_action('admin_head', function(){
	?>
<style>
	#adminmenu #menu-posts-autor > a {
		background-color: #2c63f4!important;
	}
</style>
	<?php
});

/* ADMIN COLUMNS */

add_filter( 'manage_autor_posts_columns', 'wpbc_manage_autor_posts_columns' );  
function wpbc_manage_autor_posts_columns( $defaults ) { 
   $defaults['featured-image'] = __('Featured Image', 'bootclean');
   return $defaults;
}
add_action( 'manage_autor_posts_custom_column', 'wpbc_manage_autor_posts_custom_column', 5, 2 );
function wpbc_manage_autor_posts_custom_column( $column_name, $id ) { 
   if ( $column_name === 'featured-image' ) {
	   wpbc_get_featured_image_for_columns($id); 
   }
}



/* ACF fields */


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_autor_detalles',
	'title' => 'Autor/Autora detalles',
	'fields' => array(  

		array(
			'key' => 'field_autor_thumbnail_id',
			'label' => 'Imagen',
			'name' => '_thumbnail_id',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),

		array(
			'key' => 'field_autor__descripcion_larga',
			'label' => 'Descripción',
			'name' => 'descripcion_larga',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
			'delay' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'autor',
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

endif;