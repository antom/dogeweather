$('.geo').bind('click', function(e) {
    var btn = $(this);
    
    if (btn.text() == 'wow, located!') {
        $('body').attr('class','dw00e');
        $('title').text('such weather');
        btn.removeClass('c08').text('very location');
        $('.description').text('');
        $('.location').text('');
        $('.celsius').text('');
        $('.fahrenheit').text('');
        $('.such span').remove();
        clearInterval(window.doge_interval);
        delete window.doge_interval;
    } else if (btn.text() == 'very location') {
        btn.text('so finding…');
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                $.getJSON('./api?lat=' + position.coords.latitude + '&lon=' + position.coords.longitude,function(data) {
                    $($.doge(data));
                    btn.text('wow, located!').addClass('c08');
                });
            });
        } else {
            $.getJSON('./api',function(data) {
                $($.doge(data));
                btn.text('wow, located!').addClass('c08');
            });
        }
    }

    e.preventDefault();
});

//  wow
(function($) {
    //  such plugin
    $.doge = function(options) {
        //  very jquery
        var doge = $.extend({
            id:'',
            location:'',
            description:'',
            temperature:{
                c:0,
                f:0
            },
            tings:[]
        },options),
            body = $('body'),
            r = function(arr) {
                if (!arr) arr = doge.tings;
                return arr[Math.floor(Math.random() * arr.length)];
            },
            suchtemp = parseInt(doge.temperature.celsius,10);
        
        $('body').attr(
            'class',
            'dw' + doge.id + ' bg'
        );
        $('.description').text('wow ' + doge.description);
        $('.location').text(doge.location);
        $('.celsius').text(Math.round(doge.temperature.c) + '°C');
        $('.fahrenheit').text(Math.round(doge.temperature.f) + '°F');
        
        if (!$('.such.overlay').length) {
            body.append('<div class="such overlay" />');
        }
     
        window.doge_interval = setInterval(function() {
            var colour_class = Math.floor(Math.random() * 20) + 1,
                l  = 5 + Math.round(Math.random() * 90) + '%',
                t  = 5 + Math.round(Math.random() * 90) + '%',
                fs = Math.max(20, Math.round(Math.random() * 50 + 24)) + 'px',
                title = $('title'),
                rs = Math.floor(Math.random() * 2) + 1,
                s = [
                    'so wow', 'such ' + r(),
                    'very ' + r(), 'much ' + r(),
                    'so ' + r(),
                    'wow'
                ];
            
            colour_class = 'c' + (colour_class < 10 ? '0' : '') + colour_class;
            
            $('.such.overlay').append(
                '<span style="position:absolute;left:' + l + ';top:' + t + ';font-size:' + fs + ';" class="' + colour_class + '">'
                    + r(s) +
                '</span>'
            );
            
            if ($('.such span').length > 8) {
                $('.such span:nth-child(1)').remove();
            }

            if (rs == 2) {
                document.title = r(s);
            }
        },2500);
    };
})(jQuery);