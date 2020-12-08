function hirvalto(id) {
    $('.hirblokk').hide();
    $('#'+id).show();
    $(".style-text-dot").dotdotdot();
    $('.news-filter-a').removeClass('active');
    $('#nfa-'+id).addClass('active');
}

$(window).load(function() {
    $(".style-text-dot").dotdotdot();
});
$(window).resize(function() {
    $(".style-text-dot").dotdotdot();
});

$(document).ready(function() { //video open
    $(".youtube").colorbox({
        iframe: true,
        innerWidth: "960",
        innerHeight: "540"
    });
});

$('.ticket-box-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    items: 1
})

$(window).scroll(function() {
    if ($(window).scrollTop() > 35) {
        $('.navbar').addClass('stuck');
    } else {
        $('.navbar').removeClass('stuck');
    }
});
$('.main-collapse-link').bind('click', function() {
    if ($(this).find('.icon-right').hasClass('rotate')) {
        $(this).find('.icon-right').removeClass("rotate");
    } else {
        $(this).find('.icon-right').addClass('rotate');
    }
});
$('.sub-collapse-link').bind('click', function() {
    if ($(this).find('.icon-right').hasClass('rotate')) {
        $(this).find('.icon-right').removeClass("rotate");
    } else {
        $(this).find('.icon-right').addClass('rotate');
    }
});

$('#tabellaTabs a').click(function(e) {
    e.preventDefault()
    $(this).tab('show')
})

$('#datepicker').datepicker({
    language: "hu",
    todayHighlight: true
});
$('#datepicker').on('changeDate', function() {
    $('#my_hidden_input').val(
        $('#datepicker').datepicker('getFormattedDate')
    );
});

$(document).ready(function() {
    $('#scroll-down').click(function() {
        $('.event-date-list').animate({
            scrollTop: '+=56'
        }, 100);
    });
    $('#scroll-up').click(function() {
        $('.event-date-list').animate({
            scrollTop: '-=56'
        }, 100);
    });
});function felso_menu_aktiv(par) {
    $('#flink_'+par).addClass('highlight-red');
}

$(window).resize(function() {
    if ($('#mobile-nav').hasClass('opened')) {
        $('#mobile-nav').removeClass("opened");
        $('body').removeClass('navopened');
    };
    if ($('#mobile-search').hasClass('opened')) {
        $('#mobile-search').removeClass("opened");
        $('body').removeClass('navopened');
    };
    if ($('.dropdown').hasClass('open')) {
        $('.dropdown').removeClass("open");
        $('body').removeClass('navopened');
    };
});
$('#mobile-nav-btn').bind('click', function() {
    $('#mobile-nav').addClass("opened");
    $('.navbar-top-links').addClass("stuck");
    setTimeout(function(){$('body').addClass('navopened');}, 700);
});
$('#mobile-nav-close').bind('click', function() {
    $('#mobile-nav').removeClass("opened");
    $('.navbar-top-links').removeClass("stuck");
    $('body').removeClass('navopened');
});
$('#nav-search-mobile').bind('click', function() {
    if ($('#mobile-nav').hasClass('opened')) {
        $('#mobile-nav').removeClass("opened");
    };
    $('#mobile-search').addClass("opened");
    if ($('body').hasClass('navopened')) {
        $('body').removeClass("navopened");
    };
    setTimeout(function(){$('body').addClass('navopened');}, 700);
});
$('#mobile-search-close').bind('click', function() {
    $('#mobile-search').removeClass("opened");
    if ($('body').hasClass('navopened')) {
        $('body').removeClass("navopened");
    };
    /*if ($('body').hasClass('searchopened')) {
        $('body').removeClass("searchopened");
    };*/
});
$(document).ready(function() {
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click touchstart', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().removeClass('open');
        $(this).parent().toggleClass('open');
    });
});
$(window).scroll(function() {
    if ($(window).scrollTop() > 35) {
        $('.navbar').addClass('stuck');
    } else {
        $('.navbar').removeClass('stuck');
    }
});
