<?php

namespace App\Entities;

use App\Factories\PDOFactory;
use App\Managers\CommentManager;
use App\Managers\Exceptions\UserException;
use App\Managers\PostManager;
use App\Managers\UserManager;

class Comment extends BaseEntity
{
    private ?int $id = null;
    private int $post_id;
    private ?int $author_id = null;
    private string $content = '';
    private ?string $created_at = null;
    private array $likes = [];
    private array $answers = [];
    private ?User $author = null;

    /**
     * @throws UserException
     */
    public function __construct(array $data = [])
    {
        $this->created_at = date('Y-m-d H:i:s');

        parent::__construct($data);

        if ($this->author_id != null) {
            $this->author = (new UserManager(new PDOFactory()))->getUserById($this->author_id);
        } else {
            $this->author = new User();
        }
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
    public function getAuthor(): User
    {
        return $this->author;
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
     * @throws UserException
     */
    public function getAnswers() : array
    {
        if (empty($this->answers)) {
            $manager = new CommentManager(new PDOFactory());
            $this->answers = $manager->getCommentAnswers($this->getId());
        }
        return $this->answers;
    }
}