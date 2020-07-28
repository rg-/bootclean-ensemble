<?php
/*

	$args passed

	Used like:

		$args['acf_field'] = the array containing the ACF field group holing this template fields
	
		So: $acf_field = $args['acf_field'];

*/

$acf_field = $args['acf_field'];  
$get_sections = WPBC_child_get_sections(); 

$next = '#'.$get_sections[0]['id'];
?>

<div id="inicio" class="page-header" data-get="container-diference" data-diference-maxapply="padding-left">

	<div class="container-fluid p-0" data-is-inview="detect">

		<div class="row row-no-gutters">

			<div class="col-lg-5 order-2 order-lg-1">

				<div class="gpy-lg-3 gpl-2 gpl-xl-1 gpr-2 gpr-lg-1">

					<div data-clone="#cloned-title" <?php WPBC_make_is_inview_fadeInUp_attrs(array(
							'class' => 'd-none d-lg-block mt-2'
						)); ?>>
						<h2 class="display-4 gmb-2"><?php echo $acf_field['title_header']; ?></h2>
					</div> 

					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array(
							'delay' => '.8s'
						)); ?>>
						<?php
						$text = $acf_field['col_wysiwyg'];
						$text = str_replace('Ensemble', '<em class="text-primary"><b>Ensemble</b></em>', $text);
						echo $text; ?>
					</div> 
					
					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array(
							'delay' => '2.2s',
							'class' => 'gmt-2'
						)); ?>>
						<p class="text-center text-md-left"><a href="<?php echo $next;?>" class="scroll-to btn btn-secondary" data-btn="fx">Descubrí más [icon_arrow_down sm=1]</a></p>
					</div>



					<div class="page_header_logos gmt-2 d-flex flex-row align-items-center justify-content-center justify-content-lg-between">
						<?php
							$page_header_logos = $acf_field['page_header_logos'];
							if(!empty($page_header_logos)){
								$count = 0;
								foreach ($page_header_logos as $key => $value) {
									$delay = .8 * ($count+1) . 's';
									?>
									<div <?php WPBC_make_is_inview_fadeInUp_attrs(array(
							'delay' => $delay
						)); ?>>
									<img src="[WPBC_get_attachment_image_src id='<?php echo $value['id']; ?>']" alt=" "/>
								</div>
									<?php
									$count++;
								}
							}
							?>
					</div>

				</div>

			</div>

			<div class="d-lg-none col-md-5 gpt-1 gpt-md-3 gpl-2">
				<div id="cloned-title">
					</div>
			</div>

			<div class="col-md-7 col-lg-7 order-1 order-lg-2">

				<div class="embed-responsiveX embed-responsive-1by1">

					<div class="embed-responsive-itemX">

						<?php
 
						$slick = array(
							'dots' => false,
							'arrows' => false, 
							'infinite' => false,
							'speed' => 1500,
							'autoplay' => true,
							'autoplaySpeed' => 3200,
							'fade' => true,
						);
						$slick = json_encode($slick); 

						$page_header_gallery = $acf_field['page_header_gallery'];
 
						?>

						<div class="theme-slick-slider" data-slick='<?php echo $slick; ?>'>
							<?php foreach($page_header_gallery as $k=>$v){  
								?>
								<div class="item"> 
										<?php
										$attachment_id = $v['id']; 
										$img_hi = "[WPBC_get_attachment_image_src id='".$attachment_id."']";
										$img_low = "[WPBC_get_attachment_image_src id='".$attachment_id."' size='medium']";
										?>
										<img class="ml-auto w-100" src="<?php echo $img_low; ?>" data-lazyimage-src="<?php echo $img_hi; ?>" alt=" "/>
								</div>
								<?php } ?>
						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>