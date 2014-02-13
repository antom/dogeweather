<?php

// much detection attempt. very client ip address.
function get_ip() {
  switch(true) {
    case (getenv('HTTP_FORWARDED')):
      return getenv('HTTP_FORWARDED');

    case (getenv('HTTP_FORWARDED_FOR')):
      return getenv('HTTP_FORWARDED_FOR');

    case (getenv('HTTP_X_FORWARDED')):
      return getenv('HTTP_X_FORWARDED');

    case (getenv('HTTP_X_FORWARDED_FOR')):
      return getenv('HTTP_X_FORWARDED_FOR');

    case (getenv('HTTP_CLIENT_IP')):
      return getenv('HTTP_CLIENT_IP');

    case (getenv('REMOTE_ADDR')):
      return getenv('REMOTE_ADDR');

    default:
      return 'UNKNOWN';
  }
}

// such call of api url. so assumes json. very optional decoding.
function call_api($url,$decode = 1) {
  $ch = curl_init($url);

  curl_setopt_array(
    $ch,
    array(
      CURLOPT_HTTPGET        => 1,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_FOLLOWLOCATION => 1,
      )
    );

  $request = curl_exec($ch);

  if (!$request) {
    trigger_error(curl_error($ch));
  } else {
    return ($decode)
      ? json_decode($request)
      : $request;
  }
}

// such geocoding. very by ip. so hardcoded test IP on localhost. very optional decoding.
function get_geo_by_ip($decode = 1) {
  $ip = get_ip();
  $ip = ($ip != '127.0.0.1')
    ? $ip
    : '180.76.6.19'; // so test IP.
  return call_api('http://ip-api.com/json/' . $ip,$decode);
}

// get weather by either IP or geocoding. Optional decoding.
function get_weather($decode = 1) {
  $geo = (isset($_GET['lat']) && isset($_GET['lon']))
    ? (object)array_combine(
        array('lat','lon'),
        array($_GET['lat'],$_GET['lon'])
      )
    : get_geo_by_ip();

  $api_query = ($geo && isset($geo->lat) && isset($geo->lon))
    ? 'lat=' . $geo->lat . '&lon=' . $geo->lon
    : 'q=Paris';

  return call_api('http://api.openweathermap.org/data/2.5/weather?' . $api_query,$decode);
}

// much return array. very listing of tings. so based on celcius.
function get_temperature_tings($celcius) {
  $celcius = round($celcius);

  // much switch. so array.
  switch(true) {
    case ($celcius <= -30):
      return array(
        'winter',
        'freeze',
        'polar vortex',
        'ridiculous',
        'hibernate',
        'climate change',
        'doom',
      );

    case ($celcius > -30 && $celcius <= -15):
      return array(
        'cold',
        'freeze',
        'shiver',
        'ice',
        'yuck',
        'climate change',
        'popsicle',
      );

    case ($celcius > -15 && $celcius <= -7):
      return array(
        'icy',
        'winter',
        'chill',
        'crisp',
        'brrrrr',
        'cool',
        'not okay',
      );

    case ($celcius > -7 && $celcius <= 0):
      return array(
        'icy',
        'frost',
        'numb',
        'shiver',
        'brrr',
        'chilly',
        'below freezing point',
      );

    case ($celcius > 0 && $celcius <= 10):
      return array(
        'chilly',
        'concern',
        'coat',
        'frosty',
        'uh oh',
        'brrrr',
        'almost freezing',
      );

    case ($celcius > 10 && $celcius <= 20):
      return array(
        'moderate',
        'mild',
        'okay',
        'medium',
        'cool',
        'whatever',
        'brisk',
      );

    case ($celcius > 20 && $celcius <= 30):
      return array(
        'heat',
        'warmth',
        'climate',
        'sweating',
        'balmy',
        'nice day',
        'ambient',
      );

    case ($celcius > 30):
      return array(
        'boiling',
        'bake',
        'melt',
        'dying',
        'suffer',
        'global warming',
        'tropical heat',
      );

    default:
      return array(
        'concern',
        'climate',
        'degrees',
        'shrug',
        'wow',
        'celcius',
        'farenheit',
      );
  }
}

// much icon array. very data. so select by id.
function get_icon_tings($id) {
  $tings = array(
    '01d' => array(
      'clear',
      'sky',
      'lovely',
      'amaze',
      'wonderful',
      'sun',
      'weather',
    ),
    '01n' => array(
      'night',
      'amaze',
      'clear',
      'lovely',
      'wonderful',
      'sky',
      'stars',
      'moon',
      'dark',
      'weather',
    ),
    '02d' => array(
      'cloud',
      'okay',
      'cumulus',
      'amaze',
      'sky',
      'weather',
    ),
    '02n' => array(
      'dark',
      'cumulus',
      'amaze',
      'cloud',
      'star',
      'space',
      'after dark',
      'weather',
    ),
    '03d' => array(
      'cloudy',
      'scattered',
      'overcast',
      'weather',
    ),
    '03n' => array(
      'cloud',
      'scattered',
      'clear sky',
      'night time',
      'weather',
    ),
    '04d' => array(
      'gloomy',
      'clouds',
      'shady',
      'boring',
      'weather',
    ),
    '04n' => array(
      'gloomy',
      'clouds',
      'shady',
      'boring',
      'weather',
    ),
    '09d' => array(
      'cloud',
      'showers',
      'raindrop',
      'wet',
      'weather',
    ),
    '09n' => array(
      'cloud',
      'showers',
      'raindrop',
      'wet',
      'night',
      'weather',
    ),
    '10d' => array(
      'raindrops',
      'soak',
      'wet',
      'slippery',
      'shower',
      'terrible',
      'weather',
    ),
    '10n' => array(
      'raindrops',
      'soak',
      'wet',
      'slippery',
      'shower',
      'terrible',
      'scary',
      'dark cloud',
      'night',
      'weather',
    ),
    '11d' => array(
      'thunder',
      'loud',
      'scare',
      'bolt',
      'lightning',
      'terrible',
      'hide',
      'weather',
    ),
    '11n' => array(
      'scary night',
      'thunder',
      'loud',
      'crash',
      'bolt',
      'lightning',
      'terrible',
      'hide',
      'weather',
    ),
    '13d' => array(
      'snow',
      'white',
      'soft',
      'icy',
      'snowflake',
      'powder',
      'joy',
      'shiny',
      'festive',
      'weather',
    ),
    '13n' => array(
      'snow',
      'white',
      'night time',
      'slippery',
      'icy',
      'snowflake',
      'powder',
      'joy',
      'shiny',
      'festive',
      'weather',
    ),
    '50d' => array(
      'mist',
      'vapor',
      'creepy',
      'spook',
      'blind',
      'low visbility',
      'darkness',
      'gloomy',
      'depress',
      'weather',
    ),
    '50n' => array(
      'mist',
      'vapor',
      'creepy',
      'spook',
      'blind',
      'low visbility',
      'darkness',
      'gloomy',
      'depress',
      'weather',
    ),
  );

  return (isset($tings[$id]))
    ? $tings[$id]
    : array();
}

// very endoges data. such awesomes.
function endoge_get_weather($tings = array(),$decode = 1) {
  $weather = get_weather(1);

  if ($weather) {
    $celcius = $weather->main->temp - 273.15;

    $endoged_weather = array(
      'id'          => $weather->weather[0]->icon,
      'location'    => $weather->name,
      'description' => $weather->weather[0]->description,
      'temperature' => (object)array(
        'c' => $celcius,
        'f' => $celcius * 9 / 5 + 32,
      ),
      'tings'       => array_merge(
          get_temperature_tings($celcius),
          get_icon_tings($weather->weather[0]->icon),
          $tings
      ),
    );
  } else {
    $endoged_weather = array(
      'id' => '00e',
      'location'    => 'Nowhere',
      'description' => 'Nothing',
      'temperature' => (object)array(
        'c' => $celcius,
        'f' => $celcius * 9 / 5 + 32,
      ),
      'tings'       => array_merge(
          get_temperature_tings($celcius),
          get_icon_tings($weather->weather[0]->icon),
          $tings
      ),
    );
  }

  $endoged_weather = (object)$endoged_weather;

  return ($decode)
    ? $endoged_weather
    : json_encode($endoged_weather);
}

?>