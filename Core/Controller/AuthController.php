<?php

namespace Core\Controller;

use Core\Utility\MessageHandler;
use Core\Routing\Redirect;
use Core\Model\Post;
use Core\Model\User;
use Core\Model\Comment;
use Core\View\View;

class AuthController
{

    public function showLogin()
    {
        if (User::auth()) {
            Redirect::to("/");
        }
        $view = new View("auth.login");
        $view->render();
    }

    public function login()
    {
        if (User::auth()) {
            Redirect::to("/");
        }

        if (isset($_POST["loginSubmit"])) {
            $user = new User();
            $user->username = $_POST["username"];
            $user->password = $_POST["password"];
            $user->login();
            Redirect::to("/");
        }
    }

    public function showRegister()
    {
        if (User::auth()) {
            Redirect::to("/");
        }

        $view = new View("auth.register");
        $view->render();
    }

    public function register()
    {
        if (User::auth()) {
            Redirect::to("/");
        }

        if (isset($_POST["registerSubmit"])) {

            // Check if the two passwords match
            if($_POST["password"] != $_POST["password_confirmation"]) {
                MessageHandler::add("Passwords don't match!", MessageHandler::STATUS_WARNING);
                Redirect::to("/register");
            }
            $user = new User();
            $user->username = $_POST["username"];
            $user->password = $_POST["password"];
            $user->isAdmin = 0;

            $user->register();

            // Automatically login in the user after registering.
            $user->login();
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        Redirect::to("/");
    }
}