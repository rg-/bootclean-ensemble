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
<div class="container" >

	<div class="row" data-is-inview="detect">

		<div class="col-12">
			<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
				<h2 class="section-title"><?php echo $acf_field['title']; ?></h2>
			</div>
		</div>

	</div>

	<div class="row gmb-1">
		<?php 
		$col_class = 'col-12 gmt-2 gmb-3'; 
		$items = $acf_field['items'];
		$count = 0;
		if(!empty($items)){
			foreach ($items as $key => $value) {
				$item_image = $value['item_image'];
				$img_hi = $item_image['url'];
				$img_low = $item_image['sizes']['medium'];
				$item_title = $value['item_title'];
				$item_text = $value['item_text'];

				$order_1 = 'col-md-4 p-0 order-md-1';
				$order_2 = 'col-md-8 gpy-md-3 gpr-md-6 order-md-2';
				if($count==1){
					$order_2 = 'col-md-7 gpy-md-3 gpl-md-6 order-md-1';
					$order_1 = 'col-md-4 p-0 order-md-2';
				}

			?>
<div class="<?php echo $col_class; ?>" data-is-inview-offset="-200" data-is-inview="detect">
	<div  <?php WPBC_make_is_inview_fadeInUp_attrs(array()); ?>>
		<div class="ui-box-shadow p-md-0">

			<div class="row row-no-gutters align-items-center">

				<div class="<?php echo $order_1;?>">

					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( )); ?>>
						<div class="ui-box-embed-fx embed-responsive embed-responsive-1by1">
							<div class="embed-responsive-item">
								<div class="position-relative">
									<img width="410" data-is-inview-lazysrc="<?php echo $img_hi; ?>" src="<?php echo $img_low; ?>" alt=" "/>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="<?php echo $order_2;?>">
					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.3s')); ?>>
						<h2 class="section-title sm gmt-1 gmt-md-0 mb-3"><?php echo $item_title; ?></h2>
					</div>
					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay'=>'.6s')); ?>>
						<p class="lead"><?php echo $item_text; ?></p>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>
			<?php
			$count ++;
			}
		}
		  
?>

	</div>

</div>
<?php WPBC_template_landing_next_section($args['next']); ?>