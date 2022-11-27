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
        $query = "SELECT * FROM comments WHERE post_id = :post_id";
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
}