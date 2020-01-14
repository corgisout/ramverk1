<?php

namespace Anax\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Question\HTMLForm\PostQuestionForm;
use Anax\Question\HTMLForm\PostAnswerForm;
use Anax\Question\HTMLForm\PostAnswerCommentForm;
use Anax\Question\HTMLForm\PostQuestionCommentForm;
use Anax\User\User;
use Anax\Models\Gravatar;
use Anax\Models\loginGet;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var gravatar Gravatar model for profile picture
     * @var loginGet  Checks session for active user
     */
    private $gravatar;
    private $loginGet;


    /**
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->gravatar = new Gravatar();
        $this->loginGet = new loginGet();
    }


    /**
     * Index action route handler.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $page->add("anax/question/questions", [
            "items" => $question->findAll(),
            "activeUser" => $this->loginGet->loginStatus($this->di),
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }


    public function postAction() : object
    {
        if ($this->loginGet->loginStatus($this->di) == null) {
            $page = $this->di->get("page");

            $page->add("anax/user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->findById($session->get("activeUserId"));
        $form = new PostQuestionForm($this->di, $user);
        $form->check();
        $page->add("anax/question/post", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function questionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);
        $asker = new User();
        $asker->setDb($this->di->get("dbqb"));
        $asker->findById($question->userId);
        $users = new User();
        $answers = new Answer();
        $comments = new Comment();
        $users->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));
        $comments->setDb($this->di->get("dbqb"));

        $page->add("anax/question/question", [
            "question" => $question,
            "asker" => $asker,
            "tags" => explode(" ", $question->tags),
            "users" => $users->findAll(),
            "answers" => $answers->findAll(),
            "comments" => $comments->findAll(),
            "gravatar" => $this->gravatar,
        ]);

        return $page->render([
            "title" => "Question view",
        ]);
    }


    public function answerAction(int $id) : object
    {
        if ($this->loginGet->loginStatus($this->di) == false) {
            $page = $this->di->get("page");

            $page->add("anax/user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);

        $form = new PostAnswerForm($this->di, $session->get("activeUserId"), $id);
        $form->check();

        $page->add("anax/question/answer", [
            "form" => $form->getHTML(),
            "question" => $question,
        ]);

        return $page->render([
            "title" => "Post an answer",
        ]);
    }


    public function qcommentAction(int $id) : object
    {
        $page = $this->di->get("page");
        if ($this->loginGet->loginStatus($this->di) == null) {
            $page->add("anax/user/crud/landing", [
            ]);
            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);
        $form = new PostQuestionCommentForm($this->di, $id);
        $form->check();
        $page->add("anax/question/qcomment", [
            "form" => $form->getHTML(),
            "question" => $question,
        ]);
        return $page->render([
            "title" => "Post a comment",
        ]);
    }

    public function acommentAction(int $id) : object
    {
        $page = $this->di->get("page");
        if ($this->loginGet->loginStatus($this->di) == null) {
            $page->add("anax/user/crud/landing", [
            ]);

            return $page->render([
                "title" => "Log in/Create User",
            ]);
        }
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($id);
        $form = new PostAnswerCommentForm($this->di, $id);
        $form->check();
        $page->add("anax/question/acomment", [
            "form" => $form->getHTML(),
            "answer" => $answer,
            "question" => $question,
        ]);
        return $page->render([
            "title" => "Post a comment",
        ]);
    }
}
