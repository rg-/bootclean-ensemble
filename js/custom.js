+function(t){ 
 	
	$(window).on('bc_inited',function(){
		$('[data-is-inview]').is_inview(); 
	});


	$(window).on('bc_inited, scroll, resize',function(){

		$('[data-simulate-height-off]').each(function(){

			var target = $(this).attr('data-simulate-height-off'); 
			$(this).css('height', $(target).innerHeight() );

		});

		var $dif = $('body').attr('data-maxwidth-half-diference');
		$('.slick-adjust-width .slick-list').css('padding-right', $dif+'px'); 
		$('.slick-adjust-width .slick-list').css('padding-left', $dif+'px'); 
	});

	$('[data-btn="fx"]').each(function(){ 
		var me = $(this);
		if(me.find('.fx-w').length<=0){
			var x = me.attr('data-fx-over') ? me.attr('data-fx-over') : me.html();
			me.html( '<span class="fx-w">'+ me.html() +'</span><span class="fx-x">'+ x +'</span>' );
		}
	}); 
 	
 	$('[data-slick]').on('init', function(slick){  
 		 
	});

}(jQuery); 