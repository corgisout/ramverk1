<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\UpdateUserForm;
use Anax\User\HTMLForm\PasswordUserForm;
use Anax\Question\Question;
use Anax\Question\Answer;
use Anax\User\User;

use Anax\Models\Gravatar;
use Anax\Models\loginGet;
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $gravatar;
    private $loginGet;

    public function initialize() : void
    {
        $this->gravatar = new Gravatar();
        $this->loginGet = new loginGet();
    }


    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $page->add("anax/user/crud/users", [
            "items" => $user->findAll(),
            "activeUser" => $this->loginGet->loginStatus($this->di),
            "activeUserId" => $this->loginGet->getUserId($this->di),
        ]);

        return $page->render([
            "title" => "Show users",
        ]);
    }


    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/user/crud/login", [
            "content" => $form->getHTML(),
            "userLoggedIn" => $this->loginGet->loginStatus($this->di),
        ]);

        return $page->render([
            "title" => "login page",
        ]);
    }

    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/user/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "create user page",
        ]);
    }

    public function updateAction(int $id) : object
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
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        $page->add("anax/user/crud/update", [
            "form" => $form->getHTML(),
            "id" => $id,
        ]);

        return $page->render([
            "title" => "create user page",
        ]);
    }


    public function passwordAction(int $id) : object
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
        $form = new PasswordUserForm($this->di, $id);
        $form->check();

        $page->add("anax/user/crud/password", [
            "form" => $form->getHTML(),
            "id" => $id,
        ]);
        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function profileAction(int $id = 0) : object
    {
        if ($id == 0) {
            if ($this->loginGet->loginStatus($this->di) == false) {
                $page = $this->di->get("page");

                $page->add("anax/user/crud/landing", [
                ]);

                return $page->render([
                    "title" => "Log in/Create User",
                ]);
            } else if ($this->loginGet->loginStatus($this->di) !== false) {
                $id = $this->loginGet->getUserId($this->di);
            }
        }
        $page = $this->di->get("page");
        $user = new User();
        $profilePicture = $this->gravatar->getGravatar($user->email);
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        $questions = new Question();
        $answers = new Answer();
        $questions->setDb($this->di->get("dbqb"));
        $answers->setDb($this->di->get("dbqb"));

        $page->add("anax/user/crud/profile", [
            "info" => $user,
            "activeUser" => $this->loginGet->loginStatus($this->di),
            "activeUserId" => $this->loginGet->getUserId($this->di),
            "profilePicture" => $profilePicture,
            "questions" => $questions->findAll(),
            "answers" => $answers->findAll(),
        ]);

        return $page->render([
            "title" => "User Profile",
        ]);
    }


    /**
     * Log out page
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
        $session = $this->di->get("session");
        $session->set("userLoggedIn", false);
        $session->delete("activeUser");
        $session->delete("activeUserId");
        $page = $this->di->get("page");
        $page->add("anax/user/crud/logout", [
        ]);
        return $page->render([
            "title" => "Log in/Create User",
        ]);
    }

    /**
     * Landing page for unidentified users
     *
     * @return object as a response object
     */
    public function landingAction() : object
    {
        $page = $this->di->get("page");
        $page->add("anax/user/crud/landing", [
        ]);
        return $page->render([
            "title" => "Log in/Create User",
        ]);
    }
}
