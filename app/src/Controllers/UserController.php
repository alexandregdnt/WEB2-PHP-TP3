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
    #[Route("/users/{id}", name: "user-profile", methods: [HttpMethods::GET])]
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

    #[Route("/users/{id}", name: "user-delete", methods: [HttpMethods::DELETE])]
    public function userDelete()
    {
        if (!$this->getUser() || !$this->getUser()->userRolesContains("admin")) {
            Tools::redirect("/login");
        }

        try {
            (new UserManager(new PDOFactory()))->deleteUser($_POST['id']);
            $_SESSION['success'] = "User deleted";
            Tools::redirect("/");
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            Tools::redirect("/");
        }
    }

    #[Route("/users/{id}/follow", name: "user-follow", methods: [HttpMethods::POST])]
    public function userFollow()
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        try {
            (new UserManager(new PDOFactory()))->followUser($this->getUser()->getId(), $_POST['id']);
            $_SESSION['success'] = "User followed";
            Tools::redirect("/");
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            Tools::redirect("/");
        }
    }

    #[Route("/users/{id}/unfollow", name: "user-unfollow", methods: [HttpMethods::POST])]
    public function userUnfollow()
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        try {
            (new UserManager(new PDOFactory()))->unfollowUser($this->getUser()->getId(), $_POST['id']);
            $_SESSION['success'] = "User unfollowed";
            Tools::redirect("/");
        } catch (UserException $e) {
            $_SESSION['error'] = $e->getMessage();
            Tools::redirect("/");
        }
    }

    #[Route("/users/{id}/followers", name: "user-followers", methods: [HttpMethods::GET])]
    public function userFollowers()
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->getUserById($_GET['id']);
        } catch (Exception $e) {
            $_SESSION['error'] = "User not found";
            Tools::redirect("/");
        }

        return $this->render("userFollowers.php", [
            "user" => $user,
            "userIsConnected" => $this->getUser() && $this->getUser()->getId() === $user->getId(),
            "userIsAdmin" => $this->getUser() && $this->getUser()->userRolesContains("admin"),
        ], $user->getUsername());
    }

    #[Route("/users/{id}/followings", name: "user-followings", methods: [HttpMethods::GET])]
    public function userFollowings()
    {
        if (!$this->getUser()) {
            Tools::redirect("/login");
        }

        $user = null;
        try {
            $user = (new UserManager(new PDOFactory()))->getUserById($_GET['id']);
        } catch (Exception $e) {
            $_SESSION['error'] = "User not found";
            Tools::redirect("/");
        }

        return $this->render("userFollowings.php", [
            "user" => $user,
            "userIsConnected" => $this->getUser() && $this->getUser()->getId() === $user->getId(),
            "userIsAdmin" => $this->getUser() && $this->getUser()->userRolesContains("admin"),
        ], $user->getUsername());
    }
}