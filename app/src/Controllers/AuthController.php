<?php

namespace App\Controllers;

use App\Factories\PDOFactory;
use App\Helpers\Filters;
use App\Helpers\Regex;
use App\Helpers\Tools;
use App\Managers\Exceptions\UserException;
use App\Managers\UserManager;
use App\Routes\Route;

class AuthController extends AbstractController
{
    /**
     * @throws UserException
     */
    #[Route("/auth/login", name: "login", methods: ["POST"])]
    public function login(): void
    {
        if ($this->getUser()) {
            Tools::redirect("/");
        }

        $authenticationMethod = Filters::postString('authentication-method');
        $password = Filters::postString('password');

        if (!empty($authenticationMethod) && !empty($password)) {
            if (Regex::validateEmail($authenticationMethod)) {
                $user = (new UserManager(new PDOFactory()))->getUserByEmail($authenticationMethod);
            } else if (Regex::validatePhone($authenticationMethod)) {
                $user = (new UserManager(new PDOFactory()))->getUserByPhone($authenticationMethod);
            } else {
                $user = (new UserManager(new PDOFactory()))->getUserByUsername($authenticationMethod);
            }

            if ($user->getId() != null) {
                if (password_verify($password, $user->getPassword())) {
                    $_SESSION['user'] = serialize($user);
                    Tools::redirect('/');
                } else {
                    $_SESSION['error'] = 'Wrong password';
                    Tools::redirect('/auth');
                }
            } else {
                $_SESSION['error'] = 'User not found';
                Tools::redirect('/auth');
            }
        } else {
            $_SESSION['error'] = 'Missing fields';
            Tools::redirect('/auth');
        }
    }

    #[Route("/auth/register", name: "register", methods: ["POST"])]
    public function register(): string
    {
        if ($this->getUser()) {
            Tools::redirect("/");
        }
        return $this->render("register.php", [], "Register");
    }

    #[Route("/auth/logout", name: "logout", methods: ["GET"])]
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        Tools::redirect("/");
    }
}