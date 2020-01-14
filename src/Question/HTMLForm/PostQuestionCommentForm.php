<?php

namespace Anax\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Question\Comment;

use Anax\Database\Exception\Exception;

/**
 * Example of FormModel implementation.
 */
class PostQuestionCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $parentId)
    {
        parent::__construct($di);
        $userId = $this->di->get("session")->get("activeUserId");
        $this->form->create(
            [
                "id" => __CLASS__,
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => "$userId"
                ],

                "questionId" => [
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
        $questionId   = $this->form->value("questionId") ?? null;
        $content      = $this->form->value("comment");

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->userId = $userId;
        $comment->questionId = $questionId;
        $comment->answerId = null;
        $comment->content = $content;

        try {
            $comment->save();
        } catch (Exception $e) {
            $this->form->rememberValues();
            $this->form->addOutput("Could not post question." . $e);
            return false;
        }


        $this->form->addOutput("Successfully posted comment.");
        $this->di->get("response")->redirect("user");
        return true;
    }
}
