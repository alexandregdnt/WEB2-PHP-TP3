<?php

namespace App\Controllers;

use App\Factories\PDOFactory;
use App\Helpers\Filters;
use App\Helpers\Tools;
use App\Managers\CommentManager;
use App\Managers\Exceptions\PostException;
use App\Managers\Exceptions\UserException;
use App\Managers\PostManager;
use App\Routes\Route;
use App\Types\HttpMethods;

class PostController extends AbstractController
{
    #[Route("/", name: "homepage", methods: [HttpMethods::GET])]
    public function home()
    {
        $manager = new PostManager(new PDOFactory());
        $posts = $manager->getAllPosts();

        return $this->render("home.php", [
            "posts" => $posts,
        ], "Tous les posts");
    }

    /**
     * @throws PostException
     */
    #[Route("/posts/{id}", name: "post-view", methods: [HttpMethods::GET])]
    public function postView(int $id)
    {
        $manager = new PostManager(new PDOFactory());
        $post = $manager->getPostById($id);
        try {
            $comments = $post->getComments();
        } catch (\Exception $e) {
            $comments = [];
        }

        return $this->render("postView.php", [
            "post" => $post,
            "comments" => $comments,
        ], $post->getTitle());
    }

    #[Route("/posts/create", name: "post-create", methods: [HttpMethods::GET])]
    public function postCreateView()
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        return $this->render("postCreate.php", [], "Créer un post");
    }

    #[Route("/posts/create", name: "post-create", methods: [HttpMethods::POST])]
    public function postCreatePost()
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $title = Filters::postString("title");
        $content = Filters::postString("content");

        if (!empty($title) && !empty($content)) {
            $manager = new PostManager(new PDOFactory());
            $manager->createPost($title, $content, $this->getUser()->getId());

            Tools::redirect("/");
        } else {
            $_SESSION["error"] = "Missing fields";
            Tools::redirect("/posts/create");
        }
    }

    #[Route("/posts/{id}/edit", name: "post-edit", methods: [HttpMethods::GET])]
    public function postEditView(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $post = $manager->getPostById($id);

        if ($post->getAuthorId() != $this->getUser()->getId()) {
            Tools::redirect("/");
        }

        return $this->render("postEdit.php", [
            "post" => $post,
        ], "Modifier un post");
    }

    #[Route("/posts/{id}/edit", name: "post-edit", methods: [HttpMethods::POST])]
    public function postEditPost(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $title = Filters::postString("title");
        $content = Filters::postString("content");

        if (!empty($title) && !empty($content)) {
            $manager = new PostManager(new PDOFactory());
            $manager->editPost($id, $title, $content);

            Tools::redirect("/");
        } else {
            $_SESSION["error"] = "Missing fields";
            Tools::redirect("/posts/$id/edit");
        }
    }

    #[Route("/posts/{id}/delete", name: "post-delete", methods: [HttpMethods::GET])]
    public function postDelete(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $post = $manager->getPostById($id);

        if ($post->getAuthorId() != $this->getUser()->getId()) {
            Tools::redirect("/");
        }

        $manager->deletePost($id);

        Tools::redirect("/");
    }

    #[Route("/posts/{id}/like", name: "post-like", methods: [HttpMethods::GET])]
    public function postLike(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $manager->likePost($id, $this->getUser()->getId());

        Tools::redirect("/");
    }

    #[Route("/posts/{id}/unlike", name: "post-unlike", methods: [HttpMethods::GET])]
    public function postUnlike(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $manager->unlikePost($id, $this->getUser()->getId());

        Tools::redirect("/");
    }

    #[Route("/posts/{id}/comment", name: "post-comment", methods: [HttpMethods::POST])]
    public function postComment(int $id)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $content = Filters::postString("content");

        if (!empty($content)) {
            $manager = new CommentManager(new PDOFactory());
            $manager->commentPost($id, $this->getUser()->getId(), $content);

            Tools::redirect("/");
        } else {
            $_SESSION["error"] = "Missing fields";
            Tools::redirect("/posts/$id");
        }
    }

    #[Route("/posts/{id}/comment/{commentId}/delete", name: "post-comment-delete", methods: [HttpMethods::GET])]
    public function postCommentDelete(int $id, int $commentId)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $comment = $manager->getCommentById($commentId);

        if ($comment->getAuthorId() != $this->getUser()->getId()) {
            Tools::redirect("/");
        }

        $manager->deleteComment($commentId);

        Tools::redirect("/");
    }

    #[Route("/posts/{id}/comment/{commentId}/edit", name: "post-comment-edit", methods: [HttpMethods::GET])]
    public function postCommentEditView(int $id, int $commentId)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $manager = new PostManager(new PDOFactory());
        $comment = $manager->getCommentById($commentId);

        if ($comment->getAuthorId() != $this->getUser()->getId()) {
            Tools::redirect("/");
        }

        return $this->render("postCommentEdit.php", [
            "comment" => $comment,
        ], "Modifier un commentaire");
    }

    #[Route("/posts/{id}/comment/{commentId}/edit", name: "post-comment-edit", methods: [HttpMethods::POST])]
    public function postCommentEditPost(int $id, int $commentId)
    {
        if (!$this->getUser()) {
            Tools::redirect("/?popup=login");
        }

        $content = Filters::postString("content");

        if (!empty($content)) {
            $manager = new PostManager(new PDOFactory());
            $manager->editComment($commentId, $content);

            Tools::redirect("/");
        } else {
            $_SESSION["error"] = "Missing fields";
            Tools::redirect("/posts/$id/comment/$commentId/edit");
        }
    }
}
