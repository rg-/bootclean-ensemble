<?php
/*

	Remove tabs and fields from Page Settings Group

*/

// add_filter('WPBC_group_builder__layout', 'WPBC_group_builder__layout_custom',9999,1);  

function WPBC_group_builder__layout_custom($fields){
	
	$remove = array(
		'field_layout_main_navbar_template__tab',
		'field_layout_main_navbar_template',
		'field_layout_footer__tab',
		'field_layout_footer_template',

		'field_custom_layout__tab',
		'field_custom_layout__enable',
		'field_custom_layout__custom_location',
		'field_custom_layout__container_type', 
	);
	
	foreach ($fields as $k => $field) {
		$key = $field['key'];
		// check
		if (in_array($key, $remove)) {
			unset($fields[$k]);
		}
	} // end foreach
	
	return $fields; 

}

/*

	Remove flexible rows not used

*/
add_filter('wpbc/filter/acf/builder/flexible_content/layouts', function($layouts){ 
	//unset($layouts['layout_template_part_row']); 
	//unset($layouts['layout_widgets_row']); 
	unset($layouts['layout_navbar_row']); 
	//unset($layouts['layout_flexible_row']); 
	// $layouts = array(); 
	return $layouts; 
},10,1); 