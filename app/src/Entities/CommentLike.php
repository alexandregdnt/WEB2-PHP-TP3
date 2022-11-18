<?php

namespace App\Entities;

class CommentLike extends Like
{
    private Comment $comment;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}