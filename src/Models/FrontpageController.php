<?php

namespace Anax\Models;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\User;
use Anax\Question\Question;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class FrontpageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

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
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $page->add("anax/frontpage/front", [
            "questions" => $question->findAll(),
            "users" => $user->findAll(),
        ]);

        return $page->render([
            "title" => "Show All Users",
        ]);
    }
}
