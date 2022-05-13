jQuery(function ($) {
    let map_height = document.getElementById('js-map__shadow').clientHeight;

    $('#gmap').height(map_height);
    $('#js-map__key').css('height', map_height + 'px');

    $(window).resize(function () {
        map_height = document.getElementById('js-map__shadow').clientHeight;
        $('#gmap').height(map_height);
        $('#js-map__key').css('height', map_height + 'px');
        const inframe = document.getElementById('gmap');
        iframe.contentWindow.location.reload(true);
    });

    $('#js-map__key').on({
        "mouseenter": function () {
            $('#js-map__shadow').addClass('displayNone');
        },
        "mouseleave": function () {
            $('#js-map__shadow').removeClass('displayNone');
        }
    });

    $('#js-map__key').on({
        "touchstart": function () {
            $('#js-map__shadow').addClass('displayNone');
        },
        "touchend": function () {
            setTimeout(function() {
                $('#js-map__shadow').removeClass('displayNone');
            }, 10000);
        }
    });
});