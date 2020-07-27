<?php

/*
	defined on bc/components/modal
	use on template-parts/layout/main-modal.php

*/

add_filter('wpbc/filter/layout/modal/args', function($modal_args){

	//$modal_args['modal-dialog']['class'] = 'modal-dialog-centered modal-dialog-full';
	$modal_args['modal-dialog']['class'] = 'modal-xlg';

	$modal_args['modal-close']['class'] = 'd-block';
	$modal_args['modal-close']['attrs'] = 'data-btn="fx"';
	$modal_args['modal-close']['text'] = '<small class="text-primary"><u>cerrar</u></small>';

	//$modal_args['modal-content']['class'] = 'container';
	$modal_args['modal-footer']['class'] = 'justify-content-center gpt-2';
	$modal_args['modal-footer']['content'] = '<button type="button" class="btn btn-secondary" data-dismiss="modal" data-btn="fx">Cerrar</button>'; 
	
	return $modal_args; 

},10,1);