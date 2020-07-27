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
<div class="container">

	<div class="row" data-is-inview="detect">

		<div class="col-12">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
				<h2 class="section-title text-center"><?php echo $acf_field['title']; ?></h2>
			</div>
		</div>

	</div>

	<div class="row row-twice-gutters gmy-1">
		<?php 
		$col_class = 'col-md-6 gmy-2'; 
		$items = $acf_field['items'];
		if(!empty($items)){
			foreach ($items as $key => $value) {
				$item_image = $value['item_image'];
				$img_hi = $item_image['url'];
				$img_low = $item_image['sizes']['medium'];
				$item_title = $value['item_title'];
				$item_text = $value['item_text'];
				?>
<div class="<?php echo $col_class; ?>">
	<div data-is-inview-offset="-200" data-is-inview="detect" <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
		<div class="ui-box-simple text-center">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
				<div class="position-relative">
					<img width="231" data-is-inview-lazysrc="<?php echo $img_hi; ?>" src="<?php echo $img_low; ?>" alt=" "/>
				</div>
			</div>
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.3s' )); ?>>
				<h2 class="section-title sm mb-3"><?php echo $item_title; ?></h2>
			</div>
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.6s')); ?>>
				<p class="lead"><?php echo $item_text; ?></p>
			</div>
		</div>
	</div>
</div>
				<?php
			}
		}
		  ?>

	</div>

</div>
<?php WPBC_template_landing_next_section($args['next']); ?>