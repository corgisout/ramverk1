<?php
namespace Anax\Controller;
use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test WeatherController
 */
class WeatherControllerTest extends TestCase
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


    public function testIndexActionGet()
    {
        global $di;
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        $di = $this->di;

        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $di->get("request");
        $di->get("session");
        $res = $this->controller->indexActionGet();
        $this->di->request->setPost("search", "karlskrona");
        $this->di->request->setPost("when", "past");

        $this->assertInternalType("object", $res);

        $this->di->session->getOnce("lon");

    }

    public function testIndexActionPost()
    {
        global $di;
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        $di = $this->di;

        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $di->get("request");
        $di->get("session");

        $res = $this->controller->indexActionPost();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
        $headers = $res->getHeaders();
        $hasLocationHeader = false;
        foreach ($headers as $header) {
            if (substr($header, 0, 10) === "Location: ") {
                $hasLocationHeader = true;
                $this->assertRegExp('/Location: .*weather$/', $header);
            }
        }
        $this->assertTrue($hasLocationHeader);
    }
}
