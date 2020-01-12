<?php
namespace Anax\Model;
class Weather
{
    protected $locationiqKey;
    protected $darkskyKey;

    public function setApiKeys($locationiqKey, $darkskyKey)
    {
        $this->locationiqKey = $locationiqKey;
        $this->darkskyKey = $darkskyKey;
    }
    /**
     *
     * @param $when -> 7 days in future, or 30 days in the past, $lat -> Latitude, $long -> Longitude
     * @return array of past weather
     *
     */

    public function getLocationData($search) : array
    {
        $url = "https://eu1.locationiq.com/v1/search.php?key={$this->locationiqKey}&q={$search}&format=json&limit=1";
        $response = get_headers($url);
        if($response[0] === 'HTTP/1.1 200 OK'){
                $details = json_decode(file_get_contents($url));
                return [
                    "lat" => $details[0]->lat,
                    "lon"=> $details[0]->lon,
                    "error" => null,
                ];
        } else {
            return [
                "error" => $search . " is not a city",
            ];
        }

    }
    public function getWeather($when, $lat, $lon) : array
    {
        $now = time();
        $dates = array();
        $weather = array();
        $temp = array();
        $time = array();
        if ($when == "past") {
            for ($i = 0; $i < 30; $i++) {
                $now -= 86400;
                $dates[] = $now;
            }
        } elseif($when == "future") {
            for ($i = 0; $i < 7; $i++) {
                $now += 86400;
                $dates[] = $now;
            }
        } else {
            return [
                "error" => "select a time",
            ];
        }
        for ($i = 0; $i < count($dates); $i++) {
            $details = json_decode(file_get_contents("https://api.darksky.net/forecast/{$this->darkskyKey}/{$lon},{$lat},{$dates[$i]}?lang=sv&units=si"));
            $time[] = date('Y-m-d', $details->currently->time);
            $weather[] = $details->currently->summary;
            $temp[] = $details->currently->temperature;
        }
        return [
            "time" => $time,
            "weather" => $weather,
            "temp" => $temp,
            "error" => "no error",
        ];
    }

    public function getWeatherMultiCurl($when, $lat, $lon) : array
 {
     $dates = [];
     $now = time();
     $url = "https://api.darksky.net/forecast/{$this->darkskyKey}/{$lon},{$lat}";

     if ($when == "past") {
         for ($i = 0; $i < 30; $i++) {
             $now -= 86400;
             $dates[] = $now;
         }
     } elseif($when == "future") {
         for ($i = 0; $i < 7; $i++) {
            $now += 86400;
            $dates[] = $now;
        }
     } else {
        return [
             "error" => "select a time",
        ];
    }

     $mh = curl_multi_init();
     $chAll = [];
     foreach ($dates as $days) {
         $ch = curl_init("$url,{$days}?lang=sv&units=si");
         curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true]);
         curl_multi_add_handle($mh, $ch);
         $chAll[] = $ch;
     }
     $running = null;
     do {
         curl_multi_exec($mh, $running);
     } while ($running);
     foreach ($chAll as $ch) {
         curl_multi_remove_handle($mh, $ch);
     }
     $response = [];
     foreach ($chAll as $ch) {
         $data = curl_multi_getcontent($ch);
         $response[] = json_decode($data, true);
     }
     return $response;
 }
}
