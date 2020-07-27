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
<div class="container gpt-5 gpb-3" data-is-inview="detect">

	<div class="row">

		<div class="col-md-6">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.3s' )); ?>>
				<?php
				$img_id = $acf_field['image']['id'];
				$img_id = 32;
				$img_low = do_shortcode('[WPBC_get_attachment_image_src id="'.$img_id.'" size="medium"]');
				$img_hi = do_shortcode('[WPBC_get_attachment_image_src id="'.$img_id.'"]');
				?>
				<div class="position-relative">
					<img width="482" data-is-inview-lazysrc="<?php echo $img_hi; ?>" src="<?php echo $img_low; ?>" alt=" "/>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
				<h2 class="section-title gmb-2"><?php echo $acf_field['title']; ?></h2>
			</div>
			
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.3s' )); ?>>
				<div class="lead"><?php

				$text = $acf_field['col_wysiwyg'];
				$text = str_replace('Ensemble', '<em class="text-primary"><b>Ensemble</b></em>', $text);
				echo $text; ?></div>
			</div>

			<div <?php WPBC_make_is_inview_fadeInLeft_attrs(array(
					'delay' => '2.2s',
					'class' => 'gmt-2'
				)); ?>>
				<p><a href="<?php echo $next;?>" class="scroll-to btn btn-secondary" data-btn="fx" data-fx="right">Ver libro completo [icon_arrow_right sm=1]</a></p>
			</div>

		</div>

	</div>

</div>