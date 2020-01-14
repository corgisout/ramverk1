<?php

namespace Anax\Models;

class loginGet
{

    public function loginStatus($di) : bool
    {
        $session = $di->get("session");
        if (($session->get("userLoggedIn") == false) || ($session->get("userLoggedIn") == null)) {
            return false;
        }
        return true;
    }
    public function getUser($di) : string
    {
        $session = $di->get("session");
        if (!$session->has("activeUser")) {
            return "null";
        }
        return $session->get("activeUser");
    }

    public function getUserId($di) : string
    {
        $session = $di->get("session");
        if (!$session->has("activeUserId")) {
            return "null";
        }
        return $session->get("activeUserId");
    }
}
