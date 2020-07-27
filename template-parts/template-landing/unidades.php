<?php
/*

	$args passed

	Used like:

		$args['acf_field'] = the array containing the ACF field group holing this template fields
	
		So: $acf_field = $args['acf_field'];

*/

$acf_field = $args['acf_field'];  

// _print_code($acf_field['unidades_return']);
?>
<div class="container" data-is-inview="detect">

	<div class="row">

		<div class="col-12">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
				<h2 class="section-title"><?php echo $acf_field['title']; ?></h2>
			</div>
		</div>
	
	</div>

	<div class="row align-items-end">
	
		<div class="col-md-7">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.6s' )); ?>>
				<p class="lead"><?php echo $acf_field['destacado']; ?></p>
			</div>
		</div>

		<div class="col-md-5 text-left text-md-right">
			<div <?php WPBC_make_is_inview_fadeInLeft_attrs(array( 'delay'=>'.9s' )); ?>>
				<p><a href="#" class="btn btn-link" data-btn="fx" data-fx="right">Ver libro completo [icon_arrow_right]</a></p>
			</div>
		</div>

	</div>

</div>

<div>

	<?php
	$slick = array(
 
		'dots' => false,
		'arrows' => true, 

		'prevArrow' => '<button data-btn="fx" data-fx="left" type="button" class="slick-prev custom-slick-arrow"><span class="fx-w"><i class="icon_arrow  left"></i></span><span class="fx-x"><i class="icon_arrow  left"></i></span></button>',
		'nextArrow' => '<button data-btn="fx" data-fx="right" type="button" class="slick-next custom-slick-arrow"><span class="fx-w"><i class="icon_arrow  right"></i></span><span class="fx-x"><i class="icon_arrow  right"></i></span></button>',

		'infinite' => true,
		'speed' => 1500,
		'autoplay' => false,
		'autoplaySpeed' => 3200,
		'slidesToShow' => 2,
		'slidesToScroll' => 1,
		'responsive' => array(
			array(
				'breakpoint' => 932,
				'settings' => array(
					'slidesToShow' => 1,
				)
			)
		)
	);
	$slick = json_encode($slick); 
 	

	$unidades_return = $acf_field['unidades_return'];
	$unidades_return_type = $unidades_return['unidades_return_type'];
	$unidades_return_orderby = $unidades_return['unidades_return_orderby'];
	$unidades_return_custom = $unidades_return['unidades_return_custom'];

	if($unidades_return_type == 'auto'){
		$unidades = new WP_Query( array(
			'post_type' => 'unidad',
			'numberposts' => '-1',
			'post_status' => 'publish',
			'order' => 'ASC',
			'orderby' => $unidades_return_orderby,
		) );
	} 
	if($unidades_return_type == 'custom' && !empty($unidades_return_custom) ){  
		$unidades = new WP_Query( array(
			'post_type' => 'unidad',
			'numberposts' => '-1',
			'post_status' => 'publish', 
			'order' => 'ASC',
			'post__in' => $unidades_return_custom
		) );
	}

	if($unidades->have_posts()){
		?>
<div class="theme-slick-slider slick-adjust-width" data-slick='<?php echo $slick; ?>'>
		<?php
		while ( $unidades->have_posts() ) {
			$unidades->the_post();
			if(has_post_thumbnail()){
				$img_src = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
				$img_src_low = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'medium' );

				$title = get_the_title();
				$ver_unidad_link = WPBC_get_field( 'ver_unidad_link' );
				$lecciones = WPBC_get_field( 'field_unidad__lecciones' );
				?>
<div class="item gp-2">
	<div class="ui-box-shadow ui-max-width ui-box-hover"> 
		<div class="row">
			<div class="col-sm-6">
				<img class="w-100" src="<?php echo $img_src_low;?>" data-lazyimage-src="<?php echo $img_src;?>" alt=" "/>
			</div>
			<div class="col-sm-6 gpl-sm-2">
				<p class="mt-2 mb-2"><b class="text-dark"><?php echo $title;?></b></p>
				<?php if(!empty($lecciones)){ ?>
					<ul class="arrow-list text-dark gmb-2">
						<?php foreach ($lecciones as $key => $value) { ?>
							<li><a href="<?php echo $value['leccion_link'];?>"><?php echo $value['leccion_titulo'];?></a></li>
						<?php } ?>
					</ul>
				<?php }?>
				<p class="m-0 text-right">
					<a href="<?php echo $ver_unidad_link;?>" target="_blank" data-btn="fx" data-fx="right" class="btn btn-secondary btn-sm">Ver unidad [icon_arrow_right xs=1]</a>
				</p>
			</div>
		</div> 
	</div>
</div>
				<?php
			}
		}
		
		wp_reset_postdata();
		?>
</div>
		<?php
	}

	?>

</div>

<?php WPBC_template_landing_next_section($args['next']); ?>