<?php

namespace App\Controllers;

use App\Entities\User;
use App\Factories\PDOFactory;
use App\Helpers\Filters;
use App\Helpers\Regex;
use App\Helpers\Tools;
use App\Managers\Exceptions\UserException;
use App\Managers\UserManager;
use App\Routes\Route;
use App\Types\HttpMethods;

class AuthController extends AbstractController
{
    /**
     * @throws UserException
     */
    #[Route("/auth/login", name: "login", methods: [HttpMethods::POST])]
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

    #[Route("/auth/register", name: "register", methods: [HttpMethods::POST])]
    public function register(): void
    {
        if ($this->getUser()) {
            Tools::redirect("/");
        }

        $user = new User([
            'username' => Filters::postString('username'),
            'email' => Filters::postString('email'),
            'password' => Filters::postString('password'),
            'firstname' => Filters::postString('firstname'),
            'lastname' => Filters::postString('lastname'),
            'phone' => Filters::postString('phone'),
            'date_of_birth' => Filters::postString('date_of_birth'),
            'avatar_url' => Filters::postString('avatar_url'),
            'bio' => Filters::postString('bio'),
        ]);

        try {
            (new UserManager(new PDOFactory()))->createUser($user);
            $_SESSION['success'] = 'User created';
            Tools::redirect('/');
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['completed_fields'] = $user;
            Tools::redirect('/?popup=register');
        }
    }

    #[Route("/auth/logout", name: "logout", methods: [HttpMethods::GET])]
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        Tools::redirect("/");
    }
}