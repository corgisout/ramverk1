<?php

namespace Anax\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\User;
use Anax\Question\Question;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $page->add("anax/tags/allTags", [
            "questions" => $question->findAll(),
        ]);
        return $page->render([
            "title" => "Show All tags",
        ]);
    }

    public function tagAction(string $tag) : object
    {
        $page = $this->di->get("page");
        $questions = new Question();
        $questions->setDb($this->di->get("dbqb"));
        $page->add("anax/tags/tag", [
            "questions" => $questions->findAll(),
            "tag" => $tag,
        ]);
        return $page->render([
            "title" => "Tag view",
        ]);
    }
}
