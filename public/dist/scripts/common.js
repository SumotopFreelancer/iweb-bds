(function($){
    "use strict";
    // lazy load
    $('.lazy').lazy();
    // Check email
    function isEmail(email){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    // Check number
    function isNum(number){
        var charCode = (number.which) ? number.which : number.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
    // Menu mobile
    $('nav#menu-mobi').mmenu({});
    // Active menu
    $(".menu-top ul li a").each(function(){
        var current_page_URL = location.href;
        if($(this).attr("href") !== "#"){
            var target_URL = $(this).prop("href");
            if(target_URL == current_page_URL){
                $('.menu-top ul li a').parent('li').removeClass('active');
                $(this).parent('li').addClass('active');
            }
        }
    });
    // Fixed menu top
  	var heightTop = jQuery('.header-top').outerHeight();
  	jQuery(window).scroll(function(){
  	    var scrollTop = jQuery(this).scrollTop();
        	var w = window.innerWidth;
        	if(scrollTop > heightTop){
            	jQuery('.header-top').addClass('fadeInDown fixed');
        	}else{
          	jQuery('.header-top').removeClass('fadeInDown fixed');
      	}
  	});
    // Scroll to top
    $(window).scroll(function(){
        if($(this).scrollTop() >= 200){
            $('#return-to-top').addClass('td-scroll-up-visible');
        }else{
            $('#return-to-top').removeClass('td-scroll-up-visible');
        }
    });
    $('#return-to-top').click(function(){
        $('body,html').animate({
            scrollTop : 0
        }, 'slow');
    });
})(jQuery);