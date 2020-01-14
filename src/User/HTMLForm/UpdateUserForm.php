<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Form to update an item.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update user details",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->username,
                ],

                "firstname" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->firstname,
                ],

                "lastname" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->lastname,
                ],
                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return User
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));
        $user->username = $this->form->value("username");
        $user->firstname = $this->form->value("firstname");
        $user->lastname = $this->form->value("lastname");
        $user->email = $this->form->value("email")
        $user->save();


        $this->form->addOutput("User was updated.");
        return true;
    }
}
