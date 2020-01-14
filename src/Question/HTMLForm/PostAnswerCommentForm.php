<?php

namespace Anax\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Question\Comment;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostAnswerCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $parentId)
    {
        parent::__construct($di);
        $id = $this->di->get("session")->get("activeUserId");
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => "$id"
                ],

                "answerId" => [
                    "type"        => "hidden",
                    "value"       => "$parentId",
                ],

                "comment" => [
                    "type"        => "textarea",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Submit comment",
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
        $answerId     = $this->form->value("answerId");
        $content      = $this->form->value("comment");

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->userId = $userId;
        $comment->questionId = null;
        $comment->answerId = $answerId;
        $comment->content = $content;

        try {
            $comment->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Could not post comment." . $e);
            return false;
        }


        $this->form->addOutput("posted comment.");
        $this->di->get("response")->redirect("question");
        return true;
    }
}
