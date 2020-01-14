<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "username" => [
                    "type"        => "text",
                ],

                "password" => [
                    "type"        => "password",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }


    public function callbackSubmit()
    {
        $username = $this->form->value("username");
        $password = $this->form->value("password");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->verifyPassword($username, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $session = $this->di->get("session");
        $session->set("userLoggedIn", true);
        $session->set("activeUser", $user->username);
        $session->set("activeUserId", $user->id);

        $this->form->addOutput("User " . $user->username . " logged in.");
        $this->di->get("response")->redirect("user");
        return true;
    }
}
