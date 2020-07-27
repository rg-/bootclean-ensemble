+function ($) {

	$('[data-slick]').on('init', function(slick){  
 		slick_lazy_beforeChange($(this)); 
		slick_lazybackground($(this)); 
	});
	$('[data-slick]').on('afterChange', function(e, slick, currentSlide){  
		slick_lazybackground($(this)); 
	});
	$('[data-slick]').on('beforeChange', function(e, slick, currentSlide){  
		slick_lazy_beforeChange($(this)); 
	});

	function slick_lazy_beforeChange(el){

		el.find('.slick-cloned').each(function(){ 
			
			var target = $(this).find('[data-lazyimage-src]'); 
			target.each(function(){
				var me = $(this);
				var current_img_url = me.attr('src');
				var lazy_img_url = me.attr('data-lazyimage-src');  
				me.removeClass('lazyimage-loading'); 
				me.addClass('lazyimage-loaded');
				me.attr('src', lazy_img_url); 
			});
			
		
		}); 
	}
	function slick_lazybackground(el){ 
		var count = 0;

		el.find('.slick-custom-prev').on('click',function(){
			var slider = $(this).closest('.slick-slider');
			if(slider.hasClass('slick-initialized')){
				slider.slick('slickPrev'); 
			}
		});
		el.find('.slick-custom-next').on('click',function(){
			var slider = $(this).closest('.slick-slider');
			if(slider.hasClass('slick-initialized')){
				slider.slick('slickNext'); 
			}
		});
		el.find('[data-lazyimage-src]').each(function(){

			var target = $(this); 
			var slide = target.closest('.slick-slide');
			var current_img_url = target.attr('src');
			var lazy_img_url = target.attr('data-lazyimage-src');   

			if( !slide.hasClass('slick-cloned') && slide.hasClass('slick-active') && !target.hasClass('lazyimage-loaded')){ 
				target.addClass('lazyimage-loading'); 
				target.parent().prepend('<span class="lazyimage-loader"/>'); 
				var loading = target.parent().find('.lazyimage-loader'); 
				loading.fadeIn(0); 
				var temp = $("<img>");
				temp.load(lazy_img_url, function(){
					target.removeClass('lazyimage-loading'); 
					var new_src = $(this).attr('src'); 
					target.attr('src', new_src); 
					loading.delay(300+(count*380)).fadeOut(600, function(){  
						target.addClass('lazyimage-loaded');
						loading.remove(); 
					});
				}); 
				temp.attr('src', lazy_img_url);  
				count ++;
			}

		});
		el.find('[data-lazybackground-src]').each(function(){
			var target = $(this); 
			var slide = target.closest('.slick-slide');
			var section = target.closest('[data-inview-me="detect"]');
			var current_img_url = target.css('background-image');
			var lazy_img_url = 'url('+target.data('lazybackground-src')+')'; 

			if( slide.hasClass('slick-cloned') ){
				target.removeClass('lazybackground-loading'); 
				target.addClass('lazybackground-loaded');
				target.css('background-image', lazy_img_url);
			}

			if( !slide.hasClass('slick-cloned') && slide.hasClass('slick-active') && !target.hasClass('lazybackground-loaded')){ 
				target.addClass('lazybackground-loading'); 
				target.parent().prepend('<span class="lazybackground-loader"/>'); 
				var loading = target.parent().find('.lazybackground-loader'); 
				loading.fadeIn(0);
				var background_src = target.data('lazybackground-src');  
				var temp = $("<img>");
				temp.load(background_src, function(){
					target.removeClass('lazybackground-loading'); 
					var new_src = $(this).attr('src'); 
					target.css('background-image','url('+new_src+')'); 
					loading.delay(300+(count*380)).fadeOut(600, function(){  
						target.addClass('lazybackground-loaded');
						loading.remove(); 
					});
				});
				temp.attr('src', background_src); 

				count++;
			}
			
		}); 
		
	}

}(jQuery); 