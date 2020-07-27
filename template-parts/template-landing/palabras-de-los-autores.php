<?php
/*

	$args passed

	Used like:

		$args['acf_field'] = the array containing the ACF field group holing this template fields
	
		So: $acf_field = $args['acf_field'];

*/

$acf_field = $args['acf_field'];  

//_print_code($args);
?>
<div class="container gpt-3">

	<div data-is-inview="detect">

		<div class="row">

			<div class="col-12">
				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
					<h2 class="section-title"><?php echo $acf_field['title']; ?></h2>
				</div>
			</div>

		</div>

		<div class="row gmt-2">

			<div class="col-md-6">
				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.3s')); ?>>
					<?php
					$col_1_text = $acf_field['col_1_text'];
					$col_1_text = str_replace('Ensemble', '<em class="text-primary"><b>Ensemble</b></em>', $col_1_text);
					echo $col_1_text; ?>
				</div>
			</div>

			<div class="col-md-6">
				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.9s')); ?>>
					<?php
					$col_2_text = $acf_field['col_2_text'];
					$col_2_text = str_replace('Ensemble', '<em class="text-primary"><b>Ensemble</b></em>', $col_2_text);
					echo $col_2_text; ?>
				</div>
			</div>

		</div>

	</div>

	<div class="row row-twice-gutters gmt-2 justify-content-center" data-is-inview="detect">
		<?php
 		
		$autores_return = $acf_field['autores_return'];
		$autores_return_type = $autores_return['autores_return_type'];
		$autores_return_orderby = $autores_return['autores_return_orderby'];
		$autores_return_custom = $autores_return['autores_return_custom'];

		if($autores_return_type == 'auto'){
			$autores = new WP_Query( array(
				'post_type' => 'autor',
				'numberposts' => '-1',
				'post_status' => 'publish',
				'order' => 'ASC',
				'orderby' => $autores_return_orderby,
			) );
		} 
		if($autores_return_type == 'custom' && !empty($autores_return_custom) ){  
			$autores = new WP_Query( array(
				'post_type' => 'autor',
				'numberposts' => '-1',
				'post_status' => 'publish', 
				'order' => 'ASC',
				'post__in' => $autores_return_custom,
			) );
		} 

 		if($autores->have_posts()){
 			$count = 0;
 			while ( $autores->have_posts() ) {
 				$autores->the_post(); 
 				$title = get_the_title(); 
				$descripcion_larga = WPBC_get_field( 'descripcion_larga' );
				$delay = .3 * ($count+1) . 's';
 				?>
<div class="col-lg-4 gmb-2 gmb-md-1" data-is-inview-offset="-200" data-is-inview="detect">
	<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>$delay, 'class' => 'h-100' )); ?>>
	<div class="ui-box-shadow ui-box-hover h-100 bg-light text-center pb-1">
		
		<div id="modal-to-clone-<?php echo get_the_ID(); ?>">
			<div class="ui-box-image position-relative mt-4 gmb-2">
				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
					<?php if(has_post_thumbnail()){
						$img_src = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
						$img_src_low = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'medium' );
						?>
							<img class="ui-img-rounded" width="212" data-is-inview-lazysrc="<?php echo $img_src; ?>" src="<?php echo $img_src_low; ?>" alt=" "/>
						<?php
					} else { ?>
						<img class="ui-img-rounded" width="212" src="<?php echo get_stylesheet_directory_uri(); ?>/images/px-trans.png" alt=" "/>
					<?php } ?>
				</div>
			</div>
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.3s' )); ?>>
				<h2 class="ui-box-title section-title sm mb-3"><?php echo $title; ?></h2>
			</div>
		</div>
		<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.6s' )); ?>>
		<p class="lead"><?php 
		$length = 30;
		$text = do_shortcode($descripcion_larga);
		$excerpt_length = apply_filters( 'excerpt_length', $length );
		$excerpt_more = apply_filters( 'excerpt_more', '...' );
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		$text = apply_filters( 'get_the_excerpt', $text ); 
		echo $text;
		?></p>
		</div>

		<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.9s' )); ?>>
			<p class="text-right m-0 ui-box-acction-footer">
				<?php
				$ajax_btn = admin_url('admin-ajax.php').'?action=get_template&name=ajax/autor-description&post_id='.get_the_ID();
				?>
				<button data-fx="top" data-btn="fx" type="button" class="btn" data-toggle="modal" data-target="#main-modal" data-modal-dialog-class="" data-modal-clone-body="#modal-to-clone-<?php echo get_the_ID(); ?>" data-modal-ajax-append-body="<?php echo $ajax_btn; ?>">
				  leer más
				</button>
			</p>
		</div>

	</div>
</div>
</div>
 				<?php
 				$count ++;
 			}

 			wp_reset_postdata();
 		} 
		?>

	</div>

</div>

<?php WPBC_template_landing_next_section($args['next']); ?>