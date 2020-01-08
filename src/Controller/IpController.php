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
class ipController implements ContainerInjectableInterface
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
     public function indexAction() : object
     {
         $page = $this->di->get("page");
         $ip = $this->di->request->getServer("REMOTE_ADDR");
         if (isset($_GET['submit'])) {
             $ip = $this->di->request->getGet("ip");
         }
         $validator = new \Anax\Model\ipValidation;
         $res = $validator->toJson($ip);
         $data = [
             "valid" => $res["valid"],
             "ip" => $ip,
             "domain" => $res["domain"],
             "ipv" => $res["ipv"],
             "lat" => $res["lat"],
             "lon" => $res["lon"],
             "country" => $res["country"],
             "city" => $res["city"]
         ];
         $page->add("ipVerification/ipJson", $data);

         return $page->render();
     }

}
