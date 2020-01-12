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
class MakeJsonController implements ContainerInjectableInterface
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
        $ip = $this->di->request->getGet("ip");
        $ipvalidator = new \Anax\Model\IpValidation;
        $json = $ipvalidator->toJson($ip);
        return [$json];
    }
}
