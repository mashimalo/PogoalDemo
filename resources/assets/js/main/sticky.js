$(function () {
    if ($(".has-sticky__bar").length) {
        $(window).scroll(function () {

            var $scroll = $(window).scrollTop();
            var $hasStickyBar = $('.has-sticky__bar');
            var $stickyBarContainer = $('.sticky__bar__container');

            if ($scroll >= $hasStickyBar.offset().top - 60) {

                $hasStickyBar.addClass('sticky');
                $stickyBarContainer.addClass('site-container');
                $stickyBarContainer.find('.pull-right').css({paddingRight: "0"});

            } else {

                $hasStickyBar.removeClass('sticky');
                $stickyBarContainer.removeClass('site-container');
                $stickyBarContainer.find('.pull-right').css({paddingRight: "15px"});

            }

        });
    }
});