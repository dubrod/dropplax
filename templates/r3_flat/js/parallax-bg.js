// PARALLAX - EASY BACKGROUND MOVEMENT

$(window).load(function () {
    $('.parallax-container').each(function () {
        $(this).css('background-image', 'url("' + $(this).find('img.parallax-bg').attr('src') + '")');
        $(this).find('.parallax-bg').remove();
    });
    renderParallax(false);
    $(window).scroll(function () {
        renderParallax(false);
    });
    $(window).resize(function () {
        renderParallax(false);
    });
});

function renderParallax(animate) {
    $('.parallax-container').each(function () {
        if ($(window).width() >= 1000) {
            var $element = $(this);
            var top_pos = $element.offset().top;
            var top_pos = top_pos+50; // get it away from 0, flickers at top
            var viewable_height = $(window).height();
            var current = $(window).scrollTop();
            var bg_image = new Image();
            bg_image.src = $element.css('background-image').replace(/"/g, "").replace(/url\(|\)$/ig, "");
            var bg_image_height = bg_image.height;
            var bg_height = $element.height();
            if (current + viewable_height > top_pos && current < top_pos + bg_height) {
                var bg_offset = -((bg_image_height - bg_height) * (current + viewable_height - top_pos) / (viewable_height + bg_height));
                if (animate) {
                    $element.animate({backgroundPositionY: bg_offset}, 'fast');
                } else {
                    $element.css("background-position", 'center ' + bg_offset + 'px');
                }
            }
        }
    });
}

// EOF PARALLAX - EASY BACKGROUND MOVEMENT