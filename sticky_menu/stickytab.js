jQuery(function($){ // DOM is now read and ready to be manipulated

    $(document).ready(function () {
        //Check viewport
        jQuery.extend(verge);
        var desktop = true,
            tablet = false,
            mobile = false;
        if ($.viewportW() >= 1024) {
            desktop = true;
            tablet = false;
            mobile = false;
        }
        if ($.viewportW() >= 768 && $.viewportW() <= 1023) {
            desktop = false;
            tablet = true;
            mobile = false;
        } else {
            if ($.viewportW() <= 767) {
                desktop = false;
                tablet = false;
                mobile = true;
            }
        }
        // For sticky header
        if (mobile){
            $('.sticky-container>div>a.expandable,.sticky-menu>.mobile-menu').on('click',function(e){
                if(!$(this).hasClass('active')){
                    $(this).closest('.sticky-container').find('.active').removeClass('active open').siblings('div,ul').slideToggle();
                }
                $(this).toggleClass('active').siblings('div,ul, nav').slideToggle();
                $("input:visible:first").focus();

                if($(this).hasClass('mobile-menu')){
                    $(this).toggleClass("open");
                }
                e.preventDefault();
            });
        }
        $(window).scroll(function() {
            if(desktop || tablet){
                var main_top = $('.main-nav').offset().top+100;
                var top_scroll = $(document).scrollTop();
                var left = $('.main-nav').offset().left;
                var delay=1000; //delay
                if (top_scroll > main_top){
                    setTimeout(function(){
                        $('.main-nav').css({'position' : 'fixed', 'top' : '0px','left': '0px', 'right' : '0', 'bottom' : 'auto', 'padding-top' : '0'});
                        $('.main-nav').css({'width' : '100%', 'max-width' : '850px', 'margin' : '0 auto'});
                        $('.main-nav').css({'z-index': 99});
                        $('.main-nav').css({'box-shadow' : '0px 0px 30px rgba(0, 0, 0, 0.55)'});
                        $('.main-nav').addClass("animated");
                        $('.main-nav').addClass("fadeInDown");
                        $('.wrapper').css({'padding': 34});
                    }, delay);
                }
                else if(main_top<250){ // 150 заменить на нужное
                    $('.main-nav').removeClass("animated");
                    $(".main-nav").removeAttr("style");
                }
            }
        });

    });
    //Safe mode
});
