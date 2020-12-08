"use strict";
/*------------------------------------------
		CUSTOM FUNCTION WRITE HERE
------------------------------------------*/
$(document).ready(function() {

    /* ---------------------------------------
            TOURN LOADER
    -------------------------------------- */
    $('#sport_list').on('change', function() {
        loadTourn($('#sport_list').val(),$('#season_list').val(),$('#tourn_list').val())
        return false;
    })
    $('#season_list').on('change', function() {
        loadTourn($('#sport_list').val(),$('#season_list').val(),$('#tourn_list').val())
        return false;
    })
    $('#tourn_list').on('change', function() {
        loadTourn($('#sport_list').val(),$('#season_list').val(),$('#tourn_list').val())
        return false;
    });
    function loadTourn(sport, season, tourn) {
        $('#tourn_loader').html('Загрузка...')
        $('#next_matches_loader').html('Загрузка...')
        $('#prev_matches_loader').html('Загрузка...')
        $('#players_loader').html('Загрузка...')
        jQuery.ajax({
            type: "GET",
            url: '/sport/'+$('#sport_list').val()+'/season/' + $('#season_list').val() + '/tournament/' + $('#tourn_list').val() + '/html/1',
            dataType: "json",
            success: function (response) {
                if (response.type == 'error') {
                    $('#tourn_loader').html('Ошибка загрузки соревнования')
                    $('#next_matches_loader').html('Ошибка загрузки матчей соревнования')
                    $('#prev_matches_loader').html('Ошибка загрузки матчей соревнования')
                    $('#players_loader').html('Ошибка загрузки матчей соревнования')
                } else {
                    $('#season_list').empty()
                    response['seasons'].forEach(function(item, i, arr) {
                        $('#season_list').append('<option value="'+item['id']+'">'+item['shortname']+'</option>')
                    })
                    $("#season_list option[value='"+response['currentSeason']+"']").attr("selected", "selected")

                    $('#tourn_list').empty()
                    response['tournaments'].forEach(function(item, i, arr) {
                        $('#tourn_list').append('<option value="'+item['id']+'">'+item['name']+'</option>')
                    })
                    $("#tourn_list option[value='"+response['currentTournamentId']+"']").attr("selected", "selected")
                    if('table' in response['html']) $('#tourn_loader').html(response['html']['table'])
                    else $('#tourn_loader').html('')
                    if('next_matches' in response['html']) {
                        $('#next_matches_loader').html(response['html']['next_matches'])
                        var mainswiper = new Swiper('#noqbot-upcomingmatch-slider', {
                            direction: 'vertical',
                            slidesPerView: 3,
                            spaceBetween: 10,
                            mousewheelControl: false,
                            nextButton: '.noqbot-themebtnnext',
                            prevButton: '.noqbot-themebtnprev',
                            autoplay: 0,
                        })
                    } else $('#next_matches_loader').html('')
                    if('prev_matches' in response['html']) {
                        $('#prev_matches_loader').html(response['html']['prev_matches'])
                    } else $('#prev_matches_loader').html('')
                    if('players' in response['html']) {
                        $('#players_loader').html(response['html']['players'])
                    } else $('#players_loader').html('')
                }
            }
        })
    }

    var loader_html = '<div class="system-site-wrap"><div class="system-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';

    /* ---------------------------------------
     Ajax Code for Contact Form
     --------------------------------------- */
    jQuery(document).on('click', '.submit-now', function (e) {
        e.preventDefault();
        var _this = jQuery(this);
        jQuery('body').append(loader_html);
        var serialize_data = _this.parents('.help-form').serialize();
        var dataString = serialize_data;

        var path = document.location
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/'));
        var dir = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));

        jQuery.ajax({
            type: "POST",
            url: dir + '/php/mailer.php',
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery('body').find('.system-site-wrap').remove();
                if (response.type == 'error') {
                    jQuery.sticky(response.message, {classList: 'important', speed: 200, autoclose: 500000});
                } else {
                    jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 500000});
                }
            }
        });
        return false;
    });

    /* -------------------------------------
            COLLAPSE MENU SMALL DEVICES
    -------------------------------------- */
    function collapseMenu(){
        jQuery('#noqbot-navigationm-mobile .menu-item-has-children').prepend('<span class="noqbot-dropdowarrow"><i class="fa fa-angle-down"></i></span>');
        jQuery('#noqbot-navigationm-mobile .menu-item-has-children span').on('click', function() {
            jQuery(this).next().next().slideToggle(300);
            jQuery(this).parent('#noqbot-navigationm-mobile .menu-item-has-children').toggleClass('noqbot-open');
        });
    }
    collapseMenu();
    /*------------------------------------------
            SLIDER BACKGROUND MOVE
    ------------------------------------------*/
    function sliderbgMove(){
        var moveForce = 25;
        var rotateForce = 15;
        $(document).mousemove(function(e) {
            var docX = $(document).width();
            var docY = $(document).height();
            var moveX = (e.pageX - docX/2) / (docX/2) * -moveForce;
            var moveY = (e.pageY - docY/2) / (docY/2) * -moveForce;
            var rotateY = (e.pageX / docX * rotateForce*2) - rotateForce;
            var rotateX = -((e.pageY / docY * rotateForce*2) - rotateForce);
            $('.noqbot-imglayer')
                .css('left', moveX+'px')
                .css('top', moveY+'px')
                .css('transform', 'rotateX('+rotateX+'deg) rotateY('+rotateY+'deg)');
        });
    }
    sliderbgMove();
    /*------------------------------------------
            HOME SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-home-slider', {
        nextButton: '.noqbot-btn-next',
        prevButton: '.noqbot-btn-prev',
        loop: true,
    });
    /*------------------------------------------
            NAV CLOSE
    ------------------------------------------*/
    function closeToggle(){
        $('.noqbot-nav .navbar-toggle').on('click', function(){
            $('.noqbot-nav .noqbot-close').addClass('active');
        });
        $('.noqbot-nav .noqbot-close').on('click', function(){
            $('.noqbot-nav .noqbot-close').removeClass('active');
        });
    }
    closeToggle();
    /*------------------------------------------
            SEARCH AREA
    ------------------------------------------*/
    function searchToggle(){
        $('#noqbot-btn-search').on('click', function(){
            $('.noqbot-searchbox').addClass('in');
        });
        $('#noqbot-close-search').on('click', function(){
            $('.noqbot-searchbox').removeClass('in');
        });
    }
    searchToggle();
    /*------------------------------------------
            MATCH COUNTER
    ------------------------------------------*/
    function matchCounter(){
        var launch = new Date('2017', '06', '14', '11', '15');
        var days = $('.noqbot-days');
        var hours = $('.noqbot-hours');
        var minutes = $('.noqbot-minutes');
        var seconds = $('.noqbot-seconds');
        setDate();
        function setDate(){
            var now = new Date();
            if( launch < now ){
                days.html('<h3>0</h3><h4>Day</h4>');
                hours.html('<h3>0</h3><h4>Hour</h4>');
                minutes.html('<h3>0</h3><h4>Minute</h4>');
                seconds.html('<h3>0</h3><h4>Second</h4>');
            }
            else{
                var s = -now.getTimezoneOffset()*60 + (launch.getTime() - now.getTime())/1000;
                var d = Math.floor(s/86400);
                days.html('<h3>'+d+'</h3><h4>Day'+(d>1?'s':''),'</h4>');
                s -= d*86400;
                var h = Math.floor(s/3600);
                hours.html('<h3>'+h+'</h3><h4>Hour'+(h>1?'s':''),'</h4>');
                s -= h*3600;
                var m = Math.floor(s/60);
                minutes.html('<h3>'+m+'</h3><h4>Minute'+(m>1?'s':''),'</h4>');
                s = Math.floor(s-m*60);
                seconds.html('<h3>'+s+'</h3><h4>Second'+(s>1?'s':''),'</h4>');
                setTimeout(setDate, 1000);
            }
        }
    }
    matchCounter();
    /*------------------------------------------
            PRICE RANGE
    ------------------------------------------*/
    $(function() {
        $("#noqbot-slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 75, 300 ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            }
        });
        $( "#amount" ).val( "$" + $( "#noqbot-slider-range" ).slider( "values", 0 ) + " - $" + $( "#noqbot-slider-range" ).slider( "values", 1 ));
    });
    /*------------------------------------------
            ALL MATCHS SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-match-slider', {
        direction: 'vertical',
        slidesPerView: 4,
        spaceBetween: 10,
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        //autoplay: 2000,
    });
    /*------------------------------------------
            ALL MATCHS SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-slideshow-slider', {
        slidesPerView: 1,
        pagination: '.swiper-pagination',
        paginationType: 'fraction',
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 2000,
    });
    /*------------------------------------------
            PLAYER DETAIL SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-playerslider', {
        slidesPerView: 1,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        //autoplay: 2000,
    });
    /* ---------------------------------------
            STATISTICS
     -------------------------------------- */
    try {
        $('.noqbot-statistic').appear(function () {
            $('.noqbot-statistic-count').countTo();
        });
    } catch (err) {}
    /*------------------------------------------
            ALL MATCHS SLIDER
    ------------------------------------------*/
    var mainswiper = new Swiper('#noqbot-upcomingmatch-slider', {
        direction: 'vertical',
        slidesPerView: 3,
        spaceBetween: 10,
        mousewheelControl: false,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 0,
    });
    /*------------------------------------------
            SPONSER SLIDER
    ------------------------------------------*/
    var mainswiper = new Swiper('#noqbot-sponser-slider', {
        direction: 'vertical',
        slidesPerView: 3,
        spaceBetween: 10,
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
    });
    /*------------------------------------------
            OTHER FIXTURES SLIDER
    ------------------------------------------*/
    var mainswiper = new Swiper('#noqbot-otherfixtures-slider', {
        direction: 'vertical',
        slidesPerView: 5,
        spaceBetween: 10,
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        breakpoints: {
            991: {
                slidesPerView: 3,
            }
        }
    });
    /*------------------------------------------
            ALL MATCHS SCROLLBAR
    ------------------------------------------*/
    $("#noqbot-playerscrollbar, #noqbot-matchscrollbar").mCustomScrollbar({
        axis:"y",
    });
    /* ---------------------------------------
            PRETTY PHOTO GALLERY
     -------------------------------------- */
    $("a[data-rel]").each(function () {
        $(this).attr("rel", $(this).data("rel"));
    });
    $("a[data-rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'normal',
        theme: 'dark_square',
        slideshow: 3000,
        autoplay_slideshow: false,
        social_tools: false
    });
    /*------------------------------------------
            POINTS TABLE SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-pointstable-slider', {
        direction: 'vertical',
        slidesPerView: 6,
        spaceBetween: 10,
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 2500,
    });
    /*------------------------------------------
            TESTIMONIOAL SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-testimonial-slider', {
        slidesPerView: 1,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 0,
    });
    /*------------------------------------------
            PLAYER GIRD SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-player-slider', {
        slidesPerView: 4,
        spaceBetween: 30,
        mousewheelControl: true,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 0,
        breakpoints: {
            479: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            640: {
                slidesPerView: 2,
            },
            767: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            991: {
                slidesPerView: 3,
            }
        }
    });
    /*------------------------------------------
            CONTENT ANIMATION
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-home-sliderfade', {
        autoplay: 3000,
        effect: 'fade',
        loop: true,
    });
    /*------------------------------------------
            HOME SLIDER VERTICAL
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-home-slidertwo', {
        autoplay: 3000,
        loop: true,
        direction: 'vertical',
    });
    /*------------------------------------------
            RESULT DETAIL SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-matchdetailslider', {
        slidesPerView: 1,
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        autoplay: 0,
    });
    /*------------------------------------------
            SHOP BANNER SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-shopslider', {
        loop: true,
        slidesPerView: 1,
        pagination: '.swiper-pagination',
        paginationClickable: true,
    });
    /*------------------------------------------
            PRODUCT INCREASE
    ------------------------------------------*/
    $('em.minus').on('click', function () {
        $('#quantity1').val(parseInt($('#quantity1').val(), 10) - 1);
    });
    $('em.plus').on('click', function () {
        $('#quantity1').val(parseInt($('#quantity1').val(), 10) + 1);
    });
    /*------------------------------------------
            RELATED PRODUCT SLIDER
    ------------------------------------------*/
    var swiper = new Swiper('#noqbot-relatedproductslider', {
        slidesPerView: 3,
        spaceBetween: 30,
        mousewheelControl: true,
        paginationType: 'fraction',
        nextButton: '.noqbot-themebtnnext',
        prevButton: '.noqbot-themebtnprev',
        pagination: '.swiper-pagination',
        breakpoints: {
            479: {slidesPerView: 1,},
            640: {slidesPerView: 2,},
            767: {slidesPerView: 3,},
            991: {slidesPerView: 2,}
        }
    });
    /* ---------------------------------------
            PORTFOLIO FILTERABLE
    -------------------------------------- */
    var $container = $('.noqbot-soccermedia-content');
    var $optionSets = $('.option-set');
    var $optionLinks = $optionSets.find('a');
    function doIsotopeFilter() {
        if ($().isotope) {
            var isotopeFilter = '';
            $optionLinks.each(function () {
                var selector = $(this).attr('data-filter');
                var link = window.location.href;
                var firstIndex = link.indexOf('filter=');
                if (firstIndex > 0) {
                    var id = link.substring(firstIndex + 7, link.length);
                    if ('.' + id == selector) {
                        isotopeFilter = '.' + id;
                    }
                }
            });
            $container.isotope({
                filter: isotopeFilter
            });
            $optionLinks.each(function () {
                var $this = $(this);
                var selector = $this.attr('data-filter');
                if (selector == isotopeFilter) {
                    if (!$this.hasClass('active')) {
                        var $optionSet = $this.parents('.option-set');
                        $optionSet.find('.active').removeClass('active');
                        $this.addClass('active');
                    }
                }
            });
            $optionLinks.on('click', function () {
                var $this = $(this);
                var selector = $this.attr('data-filter');
                $container.isotope({itemSelector: '.masonry-grid', filter: selector});
                if (!$this.hasClass('active')) {
                    var $optionSet = $this.parents('.option-set');
                    $optionSet.find('.active').removeClass('active');
                    $this.addClass('active');
                }
                return false;
            });
        }
    }
    var isotopeTimer = window.setTimeout(function () {
        window.clearTimeout(isotopeTimer);
        doIsotopeFilter();
    }, 1000);
    /*------------------------------------------
            HOME TWO NAVIGATION
    ------------------------------------------*/
    $('#noqbot-btnnav').on('click', function () {
        $('#noqbot-wrapper').toggleClass('noqbot-sidenavshow');
    });
    /*------------------------------------------
            HOME ONE MOBILE NAVIGATION
    ------------------------------------------*/
    $('#noqbot-close').on('click', function () {
        $('#noqbot-navigationm-mobile').removeClass('in');
    });

    /*------------------------------------------
            PRODUCT SLIDER
    ------------------------------------------*/
    function shopSlider(){
        var sync1 = $("#noqbot-productlargeslider");
        var sync2 = $("#noqbot-productthumbslider");
        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            navigation: false,
            pagination : false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200,
        });
        sync2.owlCarousel({
            items :					3,
            itemsDesktop :			[1199,3],
            itemsDesktopSmall :		[979,3],
            itemsTablet :			[767,4],
            itemsMobile :			[479,3],
            pagination : false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
                el.find(".owl-item").eq(0).addClass("noqbot-active");
            }
        });
        function syncPosition(el){
            var current = this.currentItem;
            $("#noqbot-productthumbslider")
                .find(".owl-item")
                .removeClass("noqbot-active")
                .eq(current)
                .addClass("noqbot-active");
            if($("#noqbot-productthumbslider").data("owlCarousel") !== undefined){
                center(current);
            }
        }
        $("#noqbot-productthumbslider").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo",number);
        });
        function center(number){
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            var num = number;
            var found = false;
            for(var i in sync2visible){
                if(num === sync2visible[i]){
                    var found = true;
                }
            }
            if(found===false){
                if(num>sync2visible[sync2visible.length-1]){
                    sync2.trigger("owl.goTo", num - sync2visible.length+2);
                }else{
                    if(num - 1 === -1){
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if(num === sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", sync2visible[1]);
            } else if(num === sync2visible[0]){
                sync2.trigger("owl.goTo", num-1);
            }
        }
    }
    shopSlider();
    /*------------------------------------------
            ADDRESS SLIDER
    ------------------------------------------*/
    function addressMapSlider(){
        var sync1 = $("#noqbot-mapcontent");
        var sync2 = $("#noqbot-officeaddressslider");
        sync1.owlCarousel({
            singleItem : true,
            slideSpeed : 1000,
            navigation: false,
            pagination:false,
            afterAction : syncPosition,
            responsiveRefreshRate : 200,
        });
        sync2.owlCarousel({
            items : 3,
            itemsDesktop      : [1199,3],
            itemsDesktopSmall     : [991,2],
            itemsTablet       : [767,2],
            itemsMobile       : [479,1],
            pagination:false,
            responsiveRefreshRate : 100,
            afterInit : function(el){
                el.find(".owl-item").eq(0).addClass("synced");
            }
        });
        function syncPosition(el){
            var current = this.currentItem;
            $("#noqbot-officeaddressslider")
                .find(".owl-item")
                .removeClass("synced")
                .eq(current)
                .addClass("synced");
            if($("#noqbot-officeaddressslider").data("owlCarousel") !== undefined){
                center(current);
            }
        }
        $("#noqbot-officeaddressslider").on("click", ".owl-item", function(e){
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo",number);
        });
        function center(number){
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            var num = number;
            var found = false;
            for(var i in sync2visible){
                if(num === sync2visible[i]){
                    var found = true;
                }
            }
            if(found===false){
                if(num>sync2visible[sync2visible.length-1]){
                    sync2.trigger("owl.goTo", num - sync2visible.length+2);
                }else{
                    if(num - 1 === -1){
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if(num === sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", sync2visible[1]);
            } else if(num === sync2visible[0]){
                sync2.trigger("owl.goTo", num-1);
            }
        }
    }
    addressMapSlider();
    /*------------------------------------------
            MEDIA SCROLLBAR
    ------------------------------------------*/
    $("#noqbot-soccermediascrollbar").mCustomScrollbar({
        axis:"x",
        advanced:{
            autoExpandHorizontalScroll:true
        }
    });
    /* ---------------------------------------
            MEDIA SCROLLBAR RESET
    -------------------------------------- */
    function resetScrollbar(){
        $('#noqbot-filterbale-nav li a').on('click', function () {
            $('#noqbot-soccermediascrollbar').html();
            $('#mCSB_1_container').animate({left: '0'});
        });
    }
    resetScrollbar();
});

(function($){$.sticky=$.fn.sticky=function(note,options,callback){if(typeof options==='function')callback=options;var hashCode=function(str){var hash=0,i=0,c='',len=str.length;if(len===0)return hash;for(i=0;i<len;i++){c=str.charCodeAt(i);hash=((hash<<5)-hash)+c;hash&=hash;}return's'+Math.abs(hash);},o={position:'top-right',speed:'fast',allowdupes:true,autoclose:5000,classList:''},uniqID=hashCode(note),display=true,duplicate=false,tmpl='<div class="sticky border-POS CLASSLIST" id="ID"><span class="sticky-close"></span><p class="sticky-note">NOTE</p></div>',positions=['top-right','top-center','top-left','bottom-right','bottom-center','bottom-left'];if(options)$.extend(o,options);$('.sticky').each(function(){if($(this).attr('id')===hashCode(note)){duplicate=true;if(!o.allowdupes)display=false;}if($(this).attr('id')===uniqID)uniqID=hashCode(note);});if(!$('.sticky-queue').length){$('body').append('<div class="sticky-queue '+o.position+'">');}else{$('.sticky-queue').removeClass(positions.join(' ')).addClass(o.position);}if(display){$('.sticky-queue').prepend(tmpl.replace('POS',o.position).replace('ID',uniqID).replace('NOTE',note).replace('CLASSLIST',o.classList)).find('#'+uniqID).slideDown(o.speed,function(){display=true;if(callback&&typeof callback==='function'){callback({'id':uniqID,'duplicate':duplicate,'displayed':display});}});}$('.sticky').ready(function(){if(o.autoclose){$('#'+uniqID).delay(o.autoclose).fadeOut(o.speed,function(){$(this).remove();});}});$('.sticky-close').on('click',function(){$('#'+$(this).parent().attr('id')).dequeue().fadeOut(o.speed,function(){$(this).remove();});});};})(jQuery);
