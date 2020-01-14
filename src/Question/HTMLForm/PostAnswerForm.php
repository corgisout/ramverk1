<?php

namespace Anax\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;
use Anax\Question\Question;
use Anax\Question\Answer;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $user, $question)
    {
        parent::__construct($di);
        // $id = $this->di->get("session")->get($active_userId);
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => "$user"
                ],

                "questionId" => [
                    "type"        => "hidden",
                    "value"       => "$question"
                ],

                "answer" => [
                    "type"        => "textarea",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post answer",
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
        $userId       = $this->form->value("userId");
        $questionId   = $this->form->value("questionId");
        $content      = $this->form->value("answer");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->userId = $userId;
        $answer->questionId = $questionId;
        $answer->content = $content;

        try {
            $answer->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Error answering question" . $e);
            return false;
        }


        $this->form->addOutput("Answer successfully posted.");
        return true;
    }
}
