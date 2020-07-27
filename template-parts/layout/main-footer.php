<div id="contacto" class="landing-section position-relative" data-is-inview="detect">

	<div class="container gpt-6 gpb-2">
		
		<div class="row gpt-1">
			
			<div class="col-md-6 gpr-md-5 gmb-2 gmb-md-0">

				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '0s' )); ?>>
					<h3 class="section-title sm gmb-2 text-center text-md-left">Contáctanos</h3>
				</div>

				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.3s' )); ?>>
					<div class="ui-footer-form">
						<?php
						$form_id = WPBC_get_theme_settings('footer_form');
						if($form_id){ 
							echo do_shortcode('[contact-form-7 id="'.$form_id.'" title="Formulario de contacto 1"]'); 
						}
						?>
					</div>
				</div>

			</div>

			<div class="col-md-3 gpl-md-5 gmb-2 gmb-md-0">

				<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.3s' )); ?>>
					<h3 class="section-title sm gmb-1 text-center text-md-left">Descargas</h3>
				</div>

				<?php
				$footer_descargas = WPBC_get_theme_settings('footer_descargas');
				
				if(!empty($footer_descargas)){

					$descargas_return_type = $footer_descargas['descargas_return_type'];
					$descargas_return_orderby = $footer_descargas['descargas_return_orderby'];
					$descargas_return_custom = $footer_descargas['descargas_return_custom'];
					
					if($descargas_return_type == 'auto'){
						$descargas = new WP_Query( array(
							'post_type' => 'unidad',
							'numberposts' => '-1',
							'post_status' => 'publish',
							'order' => 'ASC',
							'orderby' => $descargas_return_orderby,
						) );
					} 
					if($descargas_return_type == 'custom' && !empty($descargas_return_custom) ){  
						$descargas = new WP_Query( array(
							'post_type' => 'unidad',
							'numberposts' => '-1',
							'post_status' => 'publish', 
							'order' => 'ASC',
							'post__in' => $descargas_return_custom
						) );
					}

					if($descargas->have_posts()){
						$count = 0;
						?>
							<ul class="underline-list text-center text-md-left">
							<?php while ( $descargas->have_posts() ) {
								$descargas->the_post();
								$ver_unidad_link = WPBC_get_field( 'ver_unidad_link' );
								$delay = .3 * ($count+1) . 's';
								?>
								<li><div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => $delay )); ?>><a href="<?php echo $ver_unidad_link; ?>" target="_blank" data-btn="fx" data-fx-padding="no"><?php echo get_the_title(); ?></a></div></li>
							<?php 
							$count ++; 
						} ?>
							</ul>
						<?php
					}
					wp_reset_postdata(); 
				}
				?>

			</div>

			<div class="col-md-3">

				<div class="gpl-md-3">
					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.6s' )); ?>>
						<h3 class="section-title sm gmb-1 text-center text-md-left">Seguí nuestro canal en Youtube</h3>
					</div>
					<div <?php WPBC_make_is_inview_fadeInUp_attrs(array( 'delay' => '.8s' )); ?>>
						<p class="gmb-4 text-center text-md-left"><a href="<?php echo WPBC_get_theme_settings('footer_youtube'); ?>" target="_blank" class="btn btn-circle" data-btn="fx">[icon_youtube fill="#ffffff"]</a></p>
					</div>

				</div>

				<div <?php WPBC_make_is_inview_fadeInRight_attrs(array( 'delay' => '1.2s' )); ?>>
					<img width="264" src="<?php echo get_stylesheet_directory_uri(); ?>/images/theme/footer-dibujo.png" alt=" "/>
				</div>

			</div>

		</div>

	</div>
	 
	<div class="footer-wave">
		
		<img class="footer-hojas" width="214" src="<?php echo get_stylesheet_directory_uri(); ?>/images/theme/footer-hojas.png" alt=" "/>

	</div>

	<div class="footer-bg">

		<div class="container">
			<div class="row ui-footer-logos">

					<div class="col-md-7 mx-auto">

						<div class="d-flex align-items-center justify-content-center flex-wrap gpy-2">
							<?php
							$footer_logos = WPBC_get_theme_settings('footer_logos');
							foreach ($footer_logos as $key => $value) {
								$url = $value['url'];
								$width = round($value['width'] / 2);
								$height = $value['height'];
								?>
								<img class="gmx-2" style="height: auto;" src="<?php echo $url; ?>" width="<?php echo $width; ?>" alt=" " />
								<?php
							}
							//_print_code($footer_logos);
							?>
						</div>

					</div>

				</div>
		</div>

	</div>

</div>

<div class="footer-bg" data-simulate-height-off="#main-footer"></div>

<footer id="main-footer">
	
	<div class="footer-bg">

		<div class="container gpt-2 gpb-1">

			<div class="row ui-footer-copy">
				<div class="col-12 text-center">

					<p>Diseño, desarrollo y diagramación editorial por <a href="http://nomadeweb.com" target="_blank"><img width="90" src="<?php echo get_stylesheet_directory_uri(); ?>/images/theme/nomade.svg" alt="NomadeWeb"/></a></p>
					
					<p><?php echo WPBC_get_theme_settings("footer_copyright"); ?></p>
				
				</div>
			</div>
		
		</div>

	</div>

</footer>