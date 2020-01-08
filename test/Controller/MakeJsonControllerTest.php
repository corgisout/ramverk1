<?php
namespace Anax\Controller;
use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test the SampleController.
 */
class MakeJsonControllerTest extends TestCase
{

    public function testIndexAction()
    {
        global $di;
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $controller = new MakeJsonController();
        $controller->setDI($di);
        $di->get("request")->setGet("ip", "127.0.0.1");
        $res = $controller->indexAction();

        $this->assertEquals("127.0.0.1", $res[0]["ip"]);
        $this->assertIsArray($res);

    }
}
