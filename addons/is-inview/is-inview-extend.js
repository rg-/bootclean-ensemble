/*	 
	Applys when

		'bc.inview.on'
		'bc.inview.partial'
		'bc.inview.off' 

	is inview base constructor for extend

*/

+function ($) {

  function inviewMe_EXTEND_TYPE__on(ele){ 
    if( ele.attr('data-is-inview-once') ){
      ele.addClass('is-inview-once');
    }
    ele.find('[data-is-inview-once]').each(function(){
      $(this).addClass('is-inview-once'); 
    }); 
  }
  
  function inviewMe_EXTEND_TYPE__off(ele){ 
    if( !ele.hasClass('is-inview-once') ){   

    }   
  } 

  $('[data-is-inview="EXTEND_TYPE"]').on('bc.inview.on', function(){ 
    inviewMe_EXTEND_TYPE__on($(this)); 
  });
  $('[data-is-inview="EXTEND_TYPE"]').on('bc.inview.partial', function(){
    if($(this).attr('data-is-inview')!='detect-partial'){
      inviewMe_EXTEND_TYPE__on($(this));
    }  
  }); 
  $('[data-is-inview="EXTEND_TYPE"]').on('bc.inview.off', function(){ 
    inviewMe_EXTEND_TYPE__off($(this)); 
  }); 

}(jQuery);