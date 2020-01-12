<?php
namespace Anax\Controller;
use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test WeatherController
 */
class WeatherApiControllerTest extends TestCase
{
    // Create the di container.
    protected $di;
    protected $controller;
    /**
     * Prepare before each test.
     */
    /**
     * Test the route "index".
     */


     protected function setUp()
     {
         global $di;
         // Setup di
         $this->di = new DIFactoryConfig();
         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
         // Use a different cache dir for unit test
         $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
         // View helpers uses the global $di so it needs its value
         $di = $this->di;
         // Setup the controller
         $this->controller = new WeatherApiController();
         $this->controller->setDI($this->di);
     }
     /**
      * Test the route "index" with ip as location
      */
     public function testIndexAction1()
     {
         $request = $this->di->get("request");
         $request->setGet("search", "karlskrona");
         $res = $this->controller->indexAction();
         $this->assertIsArray($res);
         $this->assertArrayHasKey("location", $res[0]);
         $this->assertArrayHasKey("lon", $res[0]);
         $this->assertArrayHasKey("lat", $res[0]);
         $this->assertArrayHasKey("weatherInfo", $res[0]);
         $this->assertContains('karlskrona', $res[0]["location"]);


     }

     public function testIndexAction2()
     {
         $request = $this->di->get("request");
         $request->setGet("search", "80.217.191.97");
         $res = $this->controller->indexAction();
         $this->assertIsArray($res);
         $this->assertArrayHasKey("location", $res[0]);
         $this->assertArrayHasKey("lon", $res[0]);
         $this->assertArrayHasKey("lat", $res[0]);
         $this->assertArrayHasKey("weatherInfo", $res[0]);
     }

     public function testIndexAction3()
     {
         $request = $this->di->get("request");
         $request->setGet("search", "");
         $res = $this->controller->indexAction();
         $this->assertIsArray($res);
         $this->assertContains('that is not a city', $res[0]["weatherInfo"]["error"]);
     }
}
