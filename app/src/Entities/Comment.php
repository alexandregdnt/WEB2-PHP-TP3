<?php

namespace App\Entities;

class Comment extends BaseEntity
{
    private int $id;
    private int $post_id;
    private int $author_id;
    private string $content;
    private ?string $created_at = null;
    private array $likes = [];
    private array $answers = [];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }
    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function setCreatedAt(?string $created_at = null): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @param CommentLike[] $likes
     */
    public function setLikes(array $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @param Comment[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getPostId(): int
    {
        return $this->post_id;
    }
    public function getAuthorId(): int
    {
        return $this->author_id;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @return CommentLike[]
     */
    public function getLikes() : array
    {
        return $this->likes;
    }

    /**
     * @return Comment[]
     */
    public function getAnswers() : array
    {
        return $this->answers;
    }
}