<?php
namespace Anax\Controller;
use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 */
class weatherApiController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     *
     * @return array
     */
    public function indexAction() : array
    {
        $weather = $this->di->get("weather");
        $search = $this->di->request->getGet("search");
        $when = $this->di->request->getGet("when")  ?? "future";

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
       if (!isset($locationInfo["error"])){

           $weatherInfo = $weather->getWeatherMultiCurl($when,$lon,$lat);
       } else {
           $weatherInfo = ["error" => "that is not a city"];
       }
        $data = [
            "location" => $search ?? null,
            "lon" => $lon ?? null,
            "lat" => $lat ?? null,
            "weatherInfo" => $weatherInfo,
        ];
        return [$data];
    }
}
