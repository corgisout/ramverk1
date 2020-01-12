<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class weatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
     public function indexActionGet() : object
     {
        $page = $this->di->get("page");

         $data = [
             "error" => $this->di->session->getOnce("error") ?? null,
             "when" => $this->di->session->getOnce("when") ?? null,
             "search" => $this->di->session->getOnce("search") ?? null,
             "temp" => $this->di->session->getOnce("temp") ?? null,
             "weather" => $this->di->session->getOnce("weather") ?? null,
             "time" => $this->di->session->getOnce("time") ?? null,
             "lon" => $this->di->session->getOnce("lon") ?? null,
             "lat" => $this->di->session->getOnce("lat") ?? null,
         ];
         $page->add("weather/geoweather", $data);

         return $page->render();
     }
     public function indexActionPost()
     {
         $response = $this->di->get("response");
         $search = $this->di->get("request")->getPost("search");
         $when = $this->di->get("request")->getPost("when");
         $this->di->session->set("search", $search);
         $weather = $this->di->get("weather");


         $ip = $this->di->request->getGet("search");
         $validator = new \Anax\Model\ipValidation;
         $res = $validator->toJson($ip);

         if ($res["valid"] == "valid IP"){
             $locationInfo = $weather->getLocationData($res["city"]);
         } else {
             if (!isset($search)){
                $locationInfo = $weather->getLocationData("");
            } else{
                $locationInfo = $weather->getLocationData($search);
            }
        }
         $lon = $locationInfo["lon"] ?? null;
         $lat = $locationInfo["lat"] ?? null;
         $this->di->session->set("lon", $lon);
         $this->di->session->set("lat", $lat);
         $error = $locationInfo["error"] ?? null;
         $this->di->session->set("error", $error);

         if ($locationInfo["error"] == null){
             $weatherInfo = $weather->getWeather($when,$lon,$lat);
             $time = $weatherInfo["time"] ?? null;
             $this->di->session->set("time", $time);

             $temp = $weatherInfo["temp"] ?? null;
             $this->di->session->set("temp", $temp);

             $weather = $weatherInfo["weather"] ?? null;
             $this->di->session->set("weather", $weather);

             $error = $weatherInfo["error"] ?? null;
             $this->di->session->set("error", $error);
        }
         return $response->redirect("weather");
     }

}
