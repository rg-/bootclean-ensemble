<?php

if(isset($_GET['post_id'])){
	$post_id = $_GET['post_id'];
	$descripcion_larga = WPBC_get_field( 'descripcion_larga', $post_id);
	echo $descripcion_larga;
}else{
	exit;
}

?>