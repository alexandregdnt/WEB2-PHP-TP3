<?php

namespace App\Controllers;

use App\Factories\PDOFactory;
use App\Managers\PostManager;
use App\Routes\Route;

class PostController extends AbstractController
{
    #[Route("/", name: "homepage", methods: ["GET"])]
    public function home()
    {
        $manager = new PostManager(new PDOFactory());
        $posts = $manager->getAllPosts();

        return $this->render("home.php", [
            "posts" => $posts,
        ], "Tous les posts");
    }
}
