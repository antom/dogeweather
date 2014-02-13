<?php
    include(getcwd() . '/wow.php');
    $tings = array();
    $weather = endoge_get_weather($tings,!isset($_GET['json']));

    // such json. html wow
    if (isset($_GET['json'])) {
        header('content-type:application/json');
        echo $weather;
    } else {
        $rounded_temperature = $weather->temperature;

        foreach($rounded_temperature as $key => $value) {
            $rounded_temperature->$key = round($rounded_temperature->$key);
        }
        
        echo preg_replace(
            '/\{([^\{]{1,100}?)\}/e',
            '$$1',
            file_get_contents(getcwd() . '/such.tmp')
        );
    }
?>