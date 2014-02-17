<?php
    include(getcwd() . '/wow.php');

    switch(get_url()) {
        case '':
            include(getcwd() . '/such.tmp');
            break;

        case '/api':
            header('content-type:application/json');
            echo endoge_get_weather(
                array(),
                0
            );
            break;

        default:
            header('location: /');
            break;
    }
?>