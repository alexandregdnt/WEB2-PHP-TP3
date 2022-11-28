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
    #[Route("/auth/login", name: "login", methods: [HttpMethods::POST])]
    public function login(): void
    {
        if ($this->getUser()) {
            Tools::redirect("/");
        }

        $authenticationMethod = Filters::postString('authentication-method');
        $password = Filters::postString('password');

        if (!empty($authenticationMethod) && !empty($password)) {
            try {
                $manager = new UserManager(new PDOFactory());
                $user = $manager->getUserByAuthenticationMethod($authenticationMethod);

                if ($user->passwordMatch($password)) {
                    $_SESSION['user'] = serialize($user);
                    Tools::redirect("/");
                } else {
                    $_SESSION['error'] = 'Invalid credentials';
                    Tools::redirect("/?popup=login&error=invalid-credentials");
                }
            } catch (UserException $e) {
                $_SESSION['error'] = 'Invalid credentials';
                Tools::redirect("/?popup=login&error=invalid-credentials");
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

        if (!empty(Filters::postString('password')) && !empty(Filters::postString('password-confirm')) && Filters::postString('password') === Filters::postString('password-confirm')) {
            try {
                $user = new User([
                    'username' => strtolower(Filters::postString('username')),
                    'email' => strtolower(Filters::postString('email')),
                    'password' => Filters::postString('password'),
                    'firstname' => Tools::capitalize(Filters::postString('firstname')),
                    'lastname' => Tools::capitalize(Filters::postString('lastname')),
                    'phone' => Filters::postString('phone'), // NOTE: Obtional
                    'date_of_birth' => Filters::postString('date_of_birth'), // NOTE: Obtional
                ]);

                $user->setHashedPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
                $user->setId((new UserManager(new PDOFactory()))->createUser($user));
                $_SESSION['user'] = serialize($user);
                $_SESSION['success'] = 'User created';
                Tools::redirect('/');

            } catch (UserException $e) {
                $_SESSION['error'] = $e->getMessage();
                Tools::redirect('/?popup=register');
            }
        } else {
            $_SESSION['error'] = 'Passwords do not match';
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