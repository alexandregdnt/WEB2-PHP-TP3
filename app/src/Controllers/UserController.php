<?php

namespace App\Controllers;

use App\Entities\User;
use App\Factories\PDOFactory;
use App\Helpers\Tools;
use App\Managers\Exceptions\UserException;
use App\Managers\UserManager;
use App\Routes\Route;
use App\Types\HttpMethods;
use Exception;

class UserController extends AbstractController
{
    #[Route("/users/{id}", name: "user-profile", methods: ["GET"])]
    public function userView(int $id): string
    {
        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->getUserById($id);
        } catch (Exception $e) {
            $_SESSION['error'] = "User not found";
            Tools::redirect("/");
        }

        return $this->render("userProfile.php", [
            "user" => $user,
            "userIsConnected" => $this->getUser() && $this->getUser()->getId() === $user->getId(),
            "userIsAdmin" => $this->getUser() && $this->getUser()->userRolesContains("admin"),
        ], $user->getUsername());
    }

    #[Route("/users/{id}/edit", name: "user-edit", methods: [HttpMethods::PUT])]
    public function userEdit(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->getUserById($id);
        } catch (Exception $e) {
            $_SESSION['error'] = "User not found";
            Tools::redirect("/");
        }

        if ($this->getUser()->getId() !== $user->getId() && !$this->getUser()->userRolesContains("admin")) {
            $_SESSION['error'] = "You can't edit this user";
            Tools::redirect("/");
        }

        $user->setFirstname($_POST['firstname']);
        $user->setLastname($_POST['lastname']);
        $user->setBio($_POST['bio']);
        $user->setPhone($_POST['phone']);
        $user->setDateOfBirth($_POST['date_of_birth']);
        $user->setAvatarUrl($_POST['avatar_url']);
        $user->setUpdatedAt(date('Y-m-d H:i:s'));

        try {
            (new UserManager(new PDOFactory()))->updateUser($user);
            $_SESSION['success'] = "User updated";
            Tools::redirect("/");
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            Tools::redirect("/users/{$user->getId()}/edit");
        }
    }

    #[Route("/users", name: "user-profile", methods: [HttpMethods::POST])]
    public function userCreate()
    {
        Tools::redirect("/");
    }

    #[Route("/users/{id}", name: "user-delete", methods: [HttpMethods::DELETE])]
    public function userDelete()
    {
        Tools::redirect("/");
    }
}