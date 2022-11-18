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

        $this->render("home.php", [
            "posts" => $posts,
            "truc" => "je suis une string",
            "machin" => 42,
        ], "Tous les posts");
    }

    #[Route("/post/{id}/{truc}/{machin}", name: "francis", methods: ["GET"])]
    public function showOnePost(int $id, string $truc, int $machin)
    {
        $manager = new PostManager(new PDOFactory());
        $post = $manager->getOnePost($id);

        $this->render("post.php", [
            "post" => $post,
            "truc" => $truc,
            "machin" => $machin,
        ], "Un post");
    }
}
