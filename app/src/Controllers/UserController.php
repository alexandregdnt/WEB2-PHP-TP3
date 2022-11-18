<?php

namespace App\Controllers;

use App\Entities\User;
use App\Helpers\Tools;
use App\Routes\Route;
use App\Types\HttpMethods;

class UserController extends AbstractController
{
    private User $user;

    public function __construct()
    {

        $this->user = new User();
    }

    #[Route("/user/{id}", name: "user-profile", methods: [HttpMethods::GET])]
    public function userView()
    {
        $this->render("user-profile.php", [], "Un super utilisateur");
    }

    #[Route("/user/{id}", name: "user-edit", methods: [HttpMethods::GET])]
    public function userEdit()
    {
        $this->render("user-profile.php", [], "Un super utilisateur");
    }

    #[Route("/user", name: "user-profile", methods: [HttpMethods::POST])]
    public function userCreate()
    {
        Tools::redirect("/");
    }

    #[Route("/user/{id}", name: "user-delete", methods: [HttpMethods::DELETE])]
    public function userDelete()
    {
        Tools::redirect("/");
    }
}