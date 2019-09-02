$(window).load(function() {
    var boxheight = $('#news_carousel .carousel-inner').innerHeight();
    var itemlength = $('#news_carousel .item').length;
    var triggerheight = Math.round(boxheight/itemlength+1);
	$('#news_carousel .list-group-item').outerHeight(triggerheight);


		$('#rolldownslide').stop().on('mouseenter', function(event) {

    
		   $("#rolldownslide").animate({
	            top: '90%'
	        }, {
	            duration: 200,
	            complete: function() {
	                $("#rolldownslide").animate({
	                    top: '85%'
	                }, {
	                    duration: 200
	                });
	            }
	        });
	  	
  	});


});
 
$(function(){ 
	$('.orcamento_botao').on("click", function(){
		if($("input[value='"+$(this).data('checkbox')+"']:checkbox:checked").length > 0){
			$("input[value='"+$(this).data('checkbox')+"']").prop( "checked", false );
			$(this).removeClass('active');
		}else{
			$("input[value='"+$(this).data('checkbox')+"']").prop( "checked", true );
			$(this).addClass('active');
		}
	});
	var altura_slide = $(window).height() - $('#menu_topo').height();
	
	$('#pagina_cabecalho .carousel-inner .item').css({'height': altura_slide+'px'});
	$('#pagina_cabecalho .carousel-inner').css({'height': altura_slide+'px'});

	  /*----------------------------
  Page Scroll
  ------------------------------ */
  var page_scroll = $('a.page-scroll');
  page_scroll.on('click', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $($anchor.attr('href')).offset().top - 10
    }, 1500, 'easeInOutExpo');
    event.preventDefault();
  });




	/*----------------------------
	   isotope active
	  ------------------------------ */
	  // portfolio start
	  $(window).on("load", function() {
	    var $container = $('.awesome-project-content');
	    var primeiro_item = $('.awesome-menu ul li:first a').data('filter');
	    $('.awesome-menu ul li:first a').addClass('active');
	    $container.isotope({
	      filter: primeiro_item,
	      animationOptions: {
	        duration: 750,
	        easing: 'linear',
	        queue: false
	      }
	    });
	    var pro_menu = $('.project-menu li a');
	    pro_menu.on("click", function() {
	      var pro_menu_active = $('.project-menu li a.active');
	      pro_menu_active.removeClass('active');
	      $(this).addClass('active');
	      var selector = $(this).attr('data-filter');
	      $container.isotope({
	        filter: selector,
	        animationOptions: {
	          duration: 750,
	          easing: 'linear',
	          queue: false
	        }
	      });
	      return false;
	    });

	  });
	  //portfolio end
	  

	    /*---------------------
    Venobox
  --------------------- */
  var veno_box = $('.venobox');
  veno_box.venobox();
  
	$('#botao_pesquisa.fa-search').on('click', function(){
		console.log($('#barra_pesquisa').is(':hidden'));
		if($('#barra_pesquisa').is(':hidden'))
	    {
	     var height_menu = $('#menu_topo').height();
	     var height_ani  = height_menu-17;
	      $('#barra_pesquisa').stop().show().animate({top:height_ani+'px'}, 800);
	    }else{
	    	var $barra = $('#barra_pesquisa');
	      $barra.animate({top:'-1px'}, function(){
	      	$barra.hide();
	      });
	    } 
	});

	// $('.tipo_5 .bloco_post > .thumbnail_post').hover(
	// 	function(){
	// 		$(this).stop().animate({
	// 			"background-size": "150%"
	// 		}, 500);
	// 	},
	// 	function(){

	// 		$(this).stop().animate({
	// 			"background-size": "100%"
	// 		}, 'fast');
	// 	}
	// );

    $(".list-galeria-elenco",this).hover(
        function(){
            $(this).find(".jogador-inf-top").animate({top:'-168'});
            $(this).find(".jogador-inf-top p").animate({opacity:'1'},800);
        },
        function(){
             $(this).find(".jogador-inf-top").animate({top:'-25px'});
             $(this).find(".jogador-inf-top p").animate({opacity:'0'},200);
        }
    );



	$('.carousel_com_carrosel .carousel-indicators').slimScroll({
	  position: 'left',
      railVisible: true,
      height: '424px',
      width: '100%'
	});

	$('.carousel_com_carrosel .slimScrollDiv').css('position', 'absolute');

	$(document).on('click', '#menu_topo .navbar-toggle.collapsed',function(){
		$(".side-area-mask").css('display','initial');
	});

	$(document).on('click', '.side-area-mask',function(){
		$(".side-area-mask").css('display','none');
		$("#menu_topo .navbar-toggle").trigger( "click" );
	});	
	var jssor_1_SlideshowTransitions = [
	  {$Duration:1200,$Zoom:1,$Easing:{$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad},$Opacity:2},
	  {$Duration:1000,$Zoom:11,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
	  {$Duration:1200,$Zoom:1,$Rotate:1,$During:{$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
	  {$Duration:1000,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
	  {$Duration:1200,x:0.5,$Cols:2,$Zoom:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
	  {$Duration:1200,x:4,$Cols:2,$Zoom:11,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
	  {$Duration:1200,x:0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
	  {$Duration:1000,x:-4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
	  {$Duration:1200,x:-0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
	  {$Duration:1000,x:4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
	  {$Duration:1200,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
	  {$Duration:1000,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Top:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.7}},
	  {$Duration:1200,x:-4,y:2,$Rows:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Row:28},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
	  {$Duration:1200,x:1,y:2,$Cols:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:19},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.8}}
	]; 

	var jssor_1_options = {
	  $AutoPlay: true,
	  $SlideshowOptions: {
	    $Class: $JssorSlideshowRunner$,
	    $Transitions: jssor_1_SlideshowTransitions,
	    $TransitionsOrder: 1
	  },
	  $ArrowNavigatorOptions: {
	    $Class: $JssorArrowNavigator$
	  },
	  $ThumbnailNavigatorOptions: {
	    $Class: $JssorThumbnailNavigator$,
	    $Rows: 1,
	    $Cols: 6,
	    $SpacingX: 14,
	    $SpacingY: 12,
	    $Orientation: 2,
	    $Align: 156
	  }
	};


	// var img = new Image;
	// img.src = $('.bloco_destaque').css('background-image').replace(/url\(|\)$/ig, "");
	// var bgImgWidth = img.width;
	// var bgImgHeight = img.height;

	var clickEvent = false;
	$('#news_carousel').carousel({
		interval:   4000	
	}).on('click', '.list-group li', function() {
			clickEvent = true;
			$('.list-group li').removeClass('active');
			$(this).addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.list-group').children().length -1;
			var current = $('.list-group li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.list-group li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});

	
	// ScaleSlider();
	// $(window).bind("load", ScaleSlider);
	// $(window).bind("resize", ScaleSlider);
	// $(window).bind("orientationchange", ScaleSlider);
	// /*responsive code end*/

	// var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);	

	// /*responsive code begin*/
	// you can remove responsive code if you don't want the slider scales while window resizing
	// function ScaleSlider() {
	//     var refSize = jssor_1_slider.Elmt.parentNode.clientWidth;
	//     if (refSize) {
	//         refSize = Math.min(refSize, 960);
	//         refSize = Math.max(refSize, 300);
	//         jssor_1_slider.$ScaleWidth(refSize);
	//     }
	//     else {
	//         window.setTimeout(ScaleSlider, 30);
	//     }
	// }
			
});





