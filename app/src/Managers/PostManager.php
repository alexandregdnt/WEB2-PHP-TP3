<?php

namespace App\Managers;

use App\Entities\Comment;
use App\Entities\Post;
use App\Entities\User;
use App\Managers\Exceptions\PostException;
use App\Managers\Exceptions\UserException;

class PostManager extends BaseManager
{
    # DATABASE METHODS

    /**
     * @param int $id
     * @return Post
     * @throws PostException
     */
    public function getPostById(int $id): Post
    {
        $db = $this->pdo;
        $query = "SELECT * FROM posts WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new Post($data);
        } else {
            throw new PostException("Post not found");
        }
    }

    /**
     * @param int $author_id
     * @return Post[]
     * @throws PostException
     */
    public function getPostByAuthorId(int $author_id): array
    {
        try {
            $db = $this->pdo;
            $query = "SELECT * FROM posts WHERE author_id = :author_id";
            $statement = $db->prepare($query);
            $statement->bindValue(":author_id", $author_id);
            $statement->execute();
            $posts = [];
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $posts[] = new Post($data);
            }
            return $posts;
        } catch (\PDOException $e) {
            throw new PostException($e->getMessage());
        }
    }

    /**
     * @param int|null $i
     * @return Post[]
     * @throws UserException
     */
    public function getAllPosts(int $i = null): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM posts ORDER BY created_at DESC";
        $statement = $db->prepare($query);
        $statement->execute();
        $posts = [];
        $k = 0;
        if ($i == null) {
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $posts[] = new Post($data);
            }
        } else {
            while (($data = $statement->fetch(\PDO::FETCH_ASSOC)) && ($k < $i)) {
                $posts[] = new Post($data);
                $k++;
            }
        }
        return $posts;
    }

    /**
     * @param int $id
     * @return User[]
     */
    public function getPostUserLikes(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE id IN (SELECT user_id FROM user_likes WHERE post_id = :id)";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();

        $users = [];
        while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }
        return $users;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws PostException
     */
    public function createPost(Post $post): Post
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            INSERT INTO posts (author_id, title, content, hero_image_url, created_at)
            VALUES (?, ?, ?, ?, ?);");
            $request->execute(array(
                $post->getAuthorId(),
                $post->getTitle(),
                $post->getContent(),
                $post->getHeroImageUrl(),
                $post->getCreatedAt()
            ));
            $post->setId($db->lastInsertId());
            return $post;
        } catch (\PDOException $e) {
            throw new PostException($e->getMessage());
        }
    }

    /**
     * @param Post $post
     * @return Post
     * @throws PostException
     */
    public function updatePost(Post $post): Post
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            UPDATE posts
            SET title = ?, content = ?, hero_image_url = ?, updated_at = ?
            WHERE id = ?;");
            $request->execute(array(
                $post->getTitle(),
                $post->getContent(),
                $post->getHeroImageUrl(),
                $post->getUpdatedAt(),
                $post->getId()
            ));
            return $post;
        } catch (\Exception $e) {
            throw new PostException("An error occurred while updating the post");
        }
    }

    /**
     * @param Post $post
     * @return void
     * @throws PostException
     */
    public function deletePost(Post $post): void
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            DELETE FROM posts
            WHERE id = ?;");
            $request->execute(array($post->getId()));
        } catch (\Exception $e) {
            throw new PostException("An error occurred while deleting the post");
        }
    }

}
