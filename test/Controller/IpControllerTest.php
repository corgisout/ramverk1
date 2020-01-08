<?php
namespace Anax\Controller;
use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
/**
 * Test the SampleController.
 */
class IpControllerTest extends TestCase
{
    public function testIndexAction()
    {
        global $di;
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        $di = $this->di;

        $this->controller = new IpController();
        $this->controller->setDI($this->di);
        $di->get("request");
        $res = $this->controller->indexAction();

        $this->assertInternalType("object", $res);

    }
}
