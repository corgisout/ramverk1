<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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

                "firstname" => [
                    "type"        => "text",
                ],

                "lastname" => [
                    "type"        => "text",
                ],

                "email" => [
                    "type"        => "email",
                ],

                "password" => [
                    "type"        => "password",
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
     public function callbackSubmit()
     {
         $username = $this->form->value("username");
         $firstname = $this->form->value("firstname");
         $lastname = $this->form->value("lastname");
         $email = $this->form->value("email");
         $password = $this->form->value("password");
         $passwordCheck = $this->form->value("password-again");


         if ($username == "" || $firstname == "" || $lastname == "" || $email == "" || $password == "") {
             $this->form->rememberValues();
             $this->form->addOutput("please fill in all fields");
             return false;
         }
         $user = new User();
         $user->setDb($this->di->get("dbqb"));
         $user->username = $this->form->value("username");
         $user->firstname = $this->form->value("firstname");
         $user->lastname = $this->form->value("lastname");
         $user->email = $this->form->value("email");
         $user->setPassword($password);

         try {
             $user->save();
         } catch (Exception $e) {
             $this->form->rememberValues();
             $this->form->addOutput("that username is already taken");
             return false;
         }



         $this->form->addOutput("your user was created.");
         return true;
     }
 }
