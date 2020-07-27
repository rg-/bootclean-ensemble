+function ($) {

  /* ------------------ */
  /*
   *
   * $.fn.is_inview
   * v 1.2
   *
   */ 

  $.fn.is_inview = function(options) {

      var self = $(this); 

      if(self.length==0) return;

      var defaults = {

        'offset': $('body').data('is-inview-offset') ? $('body').data('is-inview-offset') : 0,
        'offsetTop': $('body').data('is-inview-offsetTop') ? $('body').data('is-inview-offsetTop') : 0,
        'offsetBottom': $('body').data('is-inview-offsetBottom') ? $('body').data('is-inview-offsetBottom') : 0,

        'breakpoint': $('body').data('is-inview-breakpoint') ? $('body').data('is-inview-breakpoint') : 'xs',

        'debug': $('body').data('is-inview-debug') ? true : false,

      }; 
      var settings = $.extend(defaults, options); 

      var in_viewport = function(me, target, is_window){ 
        var element = me;
        var viewport = target;
        var offset = element.attr('data-is-inview-offset') ? element.attr('data-is-inview-offset') : settings.offset; 
        var offset_top = element.attr('data-is-inview-offset-top') ? element.attr('data-is-inview-offset-top') : ( settings.offsetTop ? settings.offsetTop : offset);
        var offset_bottom = element.attr('data-is-inview-offset-bottom') ? element.attr('data-is-inview-offset-bottom') : ( settings.offsetBottom ? settings.offsetBottom : offset); 

        var elementTop = element.offset().top;
        var elementLeft = element.offset().left;
        var elementHeight = element.outerHeight(true); 
        var elementWidth = element.outerWidth(true); 

        
        var viewportTop = viewport.scrollTop();
        var viewportHeight = viewport.height();
        var viewportWidth = viewport.width(); 
        var viewporLeft = viewport.scrollLeft(); 
        
        //console.log('data-offset: '+offset);
        /*
        Take diferent approach when using window as target scroll element.
        If not using "window" as target, that is normal scroll body beheavior
        then, use a diferent calculation.
        */
        var viewportOffsetTop = 0;
        var viewportOffsetLeft = 0;
        if(!is_window){
          viewportOffsetTop = viewport.offset().top;
          viewportOffsetLeft = viewport.offset().left; 
        } 


        var debug = '';
        var $ele_is_inside = false;

        var $ele_is_top = false;
        var $ele_is_top_half = false;
        var $ele_is_above_top = false;

        var $ele_is_bottom = false;
        var $ele_is_bottom_half = false;
        var $ele_is_behind_bottom = false;

        if(is_window){ 

          $return = elementTop + elementHeight > viewportTop + (parseFloat(offset_top))  && 
                  elementTop < viewportTop + viewportHeight - (parseFloat(offset_bottom))  && 
                  elementLeft + elementWidth > viewporLeft && 
                  elementLeft < viewporLeft + viewportWidth;
        } else {  

          $return = elementTop + elementHeight > viewportOffsetTop + (parseFloat(offset_top))  &&
                  elementTop < viewportHeight + viewportOffsetTop - (parseFloat(offset_bottom))  &&
                  elementLeft + elementWidth > 0 && 
                  elementLeft < viewportWidth + viewportOffsetLeft;
        } 

        $ele_is_inside = $return;

        if(elementTop < viewportTop + (parseFloat(offset_top)) ){ 
          $ele_is_top = true;  
        }else{
          $ele_is_top = false; 
        }
        if(elementTop + (elementHeight/2) > viewportTop + (parseFloat(offset_top)) ){ 
          $ele_is_top_half = true; 
        }else{ 
          $ele_is_top_half = false; 
        }
        if(elementTop + elementHeight > viewportTop + (parseFloat(offset_top)) ){ 
          $ele_is_above_top = false; 
        }else{ 
          $ele_is_above_top = true; 
        } 

        if(elementTop + elementHeight > viewportTop + viewportHeight - (parseFloat(offset_bottom)) ){
          $ele_is_bottom = true;  
        }else{
          $ele_is_bottom = false;
        }

        if(elementTop + (elementHeight/2) > viewportTop + viewportHeight - (parseFloat(offset_bottom)) ){
          $ele_is_bottom_half = false;  
        }else{
          $ele_is_bottom_half = true;
        }

        if(elementTop > viewportTop + viewportHeight - (parseFloat(offset_bottom)) ){
          $ele_is_behind_bottom = true;  
        }else{
          $ele_is_behind_bottom = false;
        }

        if($return){ 
          if($ele_is_top_half && $ele_is_bottom_half){
            $return = 1;
            $cl = 'bg-success';
          }else{
            $return = 2;
            $cl = 'bg-warning';
          } 
        }

        if(settings.debug){ 

          $cl = 'bg-danger'; 

          debug += ' <span class="'+$cl+'">'+ $ele_is_inside + '</span>'; 
          debug += ' offset_top: '+ offset_top + 'offset_bottom: '+ offset_bottom + '<br>'; 
          debug += ' ele_is_top: '+ $ele_is_top + '<br>';
          debug += ' ele_is_top_half: '+ $ele_is_top_half + '<br>';
          debug += ' ele_is_above_top: '+ $ele_is_above_top + '<br>'; 
          debug += ' ele_is_bottom: '+ $ele_is_bottom + '<br>'; 
          debug += ' ele_is_bottom_half: '+ $ele_is_bottom_half + '<br>'; 
          debug += ' ele_is_behind_bottom: '+ $ele_is_behind_bottom + '<br>';  

          element.find('[data-is-inview="debug"]').html(debug); 
        }

        return $return;
        
      } 

      var if_is_breakpoint = function(me){
        var this_break = settings.breakpoint;
        if( get_window_sizes('w') > bc_config.breakpoints[this_break]){
          var is_break = true;
        }else{
          var is_break = false;
        }
        return is_break;
      }

      var make_inview_me = function(me, target, is_window){  

        make_apply_inview_me_pre(me, target, is_window);  

        if( in_viewport(me, target, is_window) ){   
          if( in_viewport(me, target, is_window) == 1){ 
            make_apply_inview_me(me, target, is_window);
          }
          if( in_viewport(me, target, is_window) == 2){ 
            make_apply_partial_inview_me(me, target, is_window);
          }
        }else{ 
          reset_apply_inview_me(me, target, is_window);
        }    
      } 

      var reset_inview_me = function(me, target, is_window){  
        reset_apply_inview_me(me, target, is_window);
      }

      var make_apply_inview_me_pre = function(me, target, is_window){  
        me.trigger('bc.inview.pre'); 
      }
      
      var prepare_inview_me = function(me, trigger_to, is_window){ 
        me.trigger('bc.inview.prepare');
      }

      var make_apply_inview_me = function(me, target, is_window){ 
        me.attr('data-is-inview-visible','on').trigger('bc.inview.on'); 
      }
      var make_apply_partial_inview_me = function(me, target, is_window){  
        me.attr('data-is-inview-visible','partial').trigger('bc.inview.partial'); 
      }

      var reset_apply_inview_me = function(me, target, is_window){ 
        me.attr('data-is-inview-visible','off').trigger('bc.inview.off');  
      } 

      /* Fired before any action */
      self.on('bc.inview.prepare',function(e){
        e.stopPropagation();
        var me = $(this);   
      }); 

      /* Fired just before bc.inview.on */
      self.on('bc.inview.pre',function(e){
        e.stopPropagation();
        var me = $(this);  
      });   

      /* Fired once element is on viewport */
      self.on('bc.inview.on',function(e){
        e.stopPropagation();
        var me = $(this);
        if(!me.hasClass('transitions-start')){
            inviewMe_check_transitions(me);
            inviewMe_addClass__on(me);
            inviewMe_normalizeCSS__on(me); 
          }
        if(if_is_breakpoint(me)){
        } 
      }); 

      self.on('bc.inview.partial',function(e){
        e.stopPropagation();
        var me = $(this); 
        if($(this).attr('data-is-inview')!='detect-partial'){
          if(!me.hasClass('transitions-start')){
            inviewMe_check_transitions(me);
            inviewMe_addClass__on(me);
            inviewMe_normalizeCSS__on(me); 
          }
        }   
        if(if_is_breakpoint(me)){
        } 
      }); 
      
      /* Fired once element is out of viewport */
      self.on('bc.inview.off',function(e){
        e.stopPropagation();
        var me = $(this);

        if(!me.hasClass('transitions-start')){
          inviewMe_addClass__off(me); 
          inviewMe_normalizeCSS__off(me); 
        } 
        if(if_is_breakpoint(me)){ 
        } 
      }); 

      var generate_ID = function () {
        // Math.random should be unique because of its seeding algorithm.
        // Convert it to base 36 (numbers + letters), and grab the first 9 characters
        // after the decimal.
        return '_' + Math.random().toString(36).substr(2, 9);
      }; 

      /* ADDONS */

      var inviewMe_check_transitions = function(el){
        el.on("webkitTransitionStart otransitionstart oTransitionStart msTransitionStart transitionstart", function(e){ 
           $(this).addClass('transitions-start'); 
           $(this).removeClass('transitions-end'); 
        });
        el.on("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(e){ 
           $(this).removeClass('transitions-start'); 
           $(this).addClass('transitions-end'); 
        });
        el.on("webkitAnimationStart oanimationstart msAnimationStart animationstart", function(e){ 
          $(this).addClass('transitions-start'); 
           $(this).removeClass('transitions-end'); 
        });
        el.on("webkitAnimationEnd oanimationend msAnimationEnd animationend", function(e){ 
          $(this).removeClass('transitions-start'); 
          $(this).addClass('transitions-end'); 
        });
      }

      // normalizeCSS

      var inviewMe_normalizeCSS = function(el){
        if(el.length>0){  
            el.css({
              'animation': el.attr('data-animation') ? el.attr('data-animation') : '',
              'animation-timing-function': el.attr('data-animation-timing-function') ? el.attr('data-animation-timing-function') : '',
              'animation-duration': el.attr('data-animation-duration') ? el.attr('data-animation-duration') : '',
              'animation-delay': el.attr('data-animation-delay') ? el.attr('data-animation-delay') : '',
              'animation-iteration-count': el.attr('data-animation-iteration-count') ? el.attr('data-animation-iteration-count') : '',
              'animation-fill-mode': el.attr('data-animation-fill-mode') ? el.attr('data-animation-fill-mode') : '',
              'animation-direction': el.attr('data-animation-direction') ? el.attr('data-animation-direction') : '',
              'animation-play-state': el.attr('data-animation-play-state') ? el.attr('data-animation-play-state') : ''
            });  
            el.css({
              'transition': el.attr('data-transition') ? el.attr('data-transition') : '',
              'transition-delay': el.attr('data-transition-delay') ? el.attr('data-transition-delay') : '',
              'transition-duration': el.attr('data-transition-duration') ? el.attr('data-transition-duration') : '',
              'transition-property': el.attr('data-transition-property') ? el.attr('data-animation-iteration-count') : '',
              'transition-timing-function': el.attr('data-transition-timing-function') ? el.attr('data-transition-timing-function') : ''
            }); 
        } 
      }

      var inviewMe_resetCSS = function(el){
        el.css('transition-delay','');
        el.css('transition-duration','');
        el.css('animation-delay','');
        el.css('animation-duration','');
      }

      // addClas

      function inviewMe_addClass__on(ele){ 
        if( ele.attr('data-is-inview-once') ){
          ele.addClass('is-inview-once');
        }
        ele.find('[data-is-inview-once]').each(function(){ 
          $(this).addClass('is-inview-once'); 
        }); 
        if(ele.attr('data-is-inview-addclass')){
          ele.addClass( ele.attr('data-is-inview-addclass') );
        } 
        ele.find('[data-is-inview-addclass]').each(function(){
          $(this).addClass( $(this).attr('data-is-inview-addclass') ); 
        });
        if(ele.attr('data-is-inview-removeclass')){
          ele.removeClass( ele.attr('data-is-inview-removeclass') ); 
        } 
        ele.find('[data-is-inview-removeclass]').each(function(){
          $(this).removeClass( $(this).attr('data-is-inview-removeclass') ); 
        }); 
      }

      function inviewMe_addClass__off(ele){ 
        if( !ele.hasClass('is-inview-once') ){ 
          if(ele.attr('data-is-inview-addclass')){
            ele.removeClass( ele.attr('data-is-inview-addclass') );
          }  
          if(ele.attr('data-is-inview-removeclass')){
            ele.addClass( ele.attr('data-is-inview-removeclass') ); 
          }   
        }  
        ele.find('[data-is-inview-addclass]').each(function(){
          if( !$(this).hasClass('is-inview-once') ){ 
            $(this).removeClass( $(this).attr('data-is-inview-addclass') ); 
          }
        });
        ele.find('[data-is-inview-removeclass]').each(function(){
          if( !$(this).hasClass('is-inview-once') ){ 
            $(this).addClass( $(this).attr('data-is-inview-removeclass') ); 
          }
        }); 
      }

      function inviewMe_normalizeCSS__on(ele){  
        var datas = '[data-transition-delay], [data-transition-duration], [data-animation-delay], [data-animation-duration]';

        if( !ele.hasClass('is-inview-once') ){  
          if(ele.is(datas)){
            inviewMe_normalizeCSS(ele);
          }
        }   
        ele.find(datas).each(function(){
           if( $(this).is(datas) ){
             inviewMe_normalizeCSS($(this));
          }
        }); 
      }

      function inviewMe_normalizeCSS__off(ele){
        var datas = '[data-transition-delay], [data-transition-duration], [data-animation-delay], [data-animation-duration]'; 
        if( !ele.hasClass('is-inview-once') ){  
          if(ele.is(datas)){
            inviewMe_resetCSS(ele);
          }
        }    
        ele.find(datas).each(function(){
           if( !$(this).hasClass('is-inview-once') ){
             inviewMe_resetCSS($(this));
          }
        }); 
      } 
      /* ADDONS END */

      /* RETURN PLUGIN */

      return self.each(function(){
        var me = $(this);
        /*
        Should i use/move thing into settings and also let data-* or ? to define those things globaly
        */
        var trigger_to = $(window); 
        var is_window = true; 

        var closest_target = me.closest('[data-is-inview-holder]');
        if($(closest_target).length>0){ 
          if(!$(closest_target).attr('id')){
            $(closest_target).attr('id', '_' + Math.random().toString(36).substr(2, 9) );
          }
          me.attr('data-is-inview-target', '#'+$(closest_target).attr('id'));
          $(closest_target).addClass('is-inview-holder'); 
        }

        if( me.attr('data-is-inview-target') && me.attr('data-is-inview-target') != 'window' ){ 
          trigger_to = $(me.attr('data-is-inview-target'));
          trigger_to.addClass('is-inview-holder');
          is_window = false;
        }  
         
        prepare_inview_me(me, trigger_to, is_window);  

        $(window).on('resize', function(e){ 
          //console.log('## on resize'); 
          make_inview_me(me, trigger_to, is_window);
        });

        trigger_to.on("scroll", function(e){
          //console.log('## on scroll'); 
          make_inview_me(me, $(this), is_window);
        }); 

        $(window).on('bc_inited', function(e){ 
          //console.log('## on bc_inited');
          make_inview_me(me, trigger_to, is_window); 
        });

      });

      /* RETURN PLUGIN END */

  }

  /* $.fn.inview_me END */ 

  /*
  
  Init by :: $('[data-is-inview]').is_inview(); 

  */
  

  }(jQuery);
 

/*
  
  normalizeCSS

  animation/transition data-* addons included

*/

+function ($) { 

  

}(jQuery);