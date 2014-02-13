$('.geo').bind('click', function(e) {
    var btn = $(this);
    
    if (btn.text() == 'wow, located!') {
        btn.removeClass('c08').text('very location');
        clearInterval(window.doge_interval);
        delete window.doge_interval;
        $('.such span').remove();
    } else if (btn.text() == 'very location') {
        if (navigator.geolocation) {
            btn.text('so finding…');
            navigator.geolocation.getCurrentPosition(function(position) {
                $.getJSON('./?json&lat=' + position.coords.latitude + '&lon=' + position.coords.longitude,function(data) {
                    $($.doge(data));
                    btn.text('wow, located!').addClass('c08');
                }); 
            });
        } else {
            btn.text('so unsupported. much sadness.');
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
            suchtemp = parseInt(doge.temperature.celsius,10),
            interval,
            colour_class;
        
        $('body').attr(
            'class',
            'dw' + doge.id + ' bg'
        );
        $('.description').text('wow ' + doge.description);
        $('.location').text(doge.location);
        $('.celsius').text(Math.round(doge.temperature.c) + '°C');
        $('.fahrenheit').text(Math.round(doge.temperature.f) + '°F');
        
        body.append('<div class="such overlay" />').children('.such.overlay');
     
        window.doge_interval = setInterval(function() {
            var l  = 5 + Math.round(Math.random() * 90) + '%',
                t  = 5 + Math.round(Math.random() * 90) + '%',
                fs = Math.max(20, Math.round(Math.random() * 50 + 24)) + 'px',
                s = r([
                    'so wow', 'such ' + r(),
                    'very ' + r(), 'much ' + r(),
                    'so ' + r(),
                    'wow'
                ]);
            
            colour_class = Math.floor(Math.random() * 20);
            colour_class = 'c' + (colour_class < 10 ? '0' : '') + colour_class;
            
            $('.such.overlay').append(
                '<span style="position:absolute;left:' + l + ';top:' + t + ';font-size:' + fs + ';" class="' + colour_class + '">'
                    + s +
                '</span>'
            );
            
            if ($('.such span').length > 8) {
                $('.such span:nth-child(1)').remove();
            }
        },2500);
    };
})(jQuery);