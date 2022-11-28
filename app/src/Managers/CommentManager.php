<?php

namespace App\Managers;

use App\Entities\Comment;
use App\Managers\Exceptions\UserException;

class CommentManager extends BaseManager
{

    /**
     * @param int $post_id
     * @return Comment[]
     * @throws UserException
     */
    public function getPostComments(int $post_id): array {
        $db = $this->pdo;
        $query = "SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at ASC";
        $statement = $db->prepare($query);
        $statement->bindValue(":post_id", $post_id);
        $statement->execute();
        $comments = [];
        while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        foreach ($comments as $comment) {
            $comment->getAnswers($comment->getId());
        }
        return $comments;
    }

    /**
     * @param int $id
     * @return Comment[]
     * @throws UserException
     */
    public function getCommentAnswers(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM comment_answers WHERE comment_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $comments = [];
        while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        return $comments;
    }

    public function commentPost(int $post_id, int $author_id, string $content): void
    {
        $db = $this->pdo;
        $query = "INSERT INTO comments (post_id, author_id, content) VALUES (:post_id, :author_id, :content)";
        $statement = $db->prepare($query);
        $statement->bindValue(":post_id", $post_id);
        $statement->bindValue(":author_id", $author_id);
        $statement->bindValue(":content", $content);
        $statement->execute();
    }
}