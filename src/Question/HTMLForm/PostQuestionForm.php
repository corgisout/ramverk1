<?php

namespace Anax\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;
use Anax\Question\Question;


use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $user)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => $user->id,
                ],

                "question" => [
                    "type"        => "textarea",
                    "placeholder" => "question",
                ],
                "tags" => [
                    "type"        => "text",
                    "placeholder" => "seperate with space",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post question",
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
        $userId    = $this->form->value("userId");
        $content   = $this->form->value("question");
        $tags      = $this->form->value("tags");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->userId = $userId;
        $question->content = $content;
        $question->tags = $tags;

        try {
            $question->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("An error occured" . $e);
            return false;
        }

        $this->form->addOutput("Question successfully posted.");
        return true;
    }
}
