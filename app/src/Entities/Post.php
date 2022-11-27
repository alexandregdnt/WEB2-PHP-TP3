<?php

namespace App\Entities;

use App\Entities\BaseEntity;
use App\Factories\PDOFactory;
use App\Managers\Exceptions\UserException;
use App\Managers\UserManager;

class Post extends BaseEntity {
    private int | null $id = null;
    private int | null $author_id = null;
    private string $title = '';
    private string $content = '';
    private string | null $hero_image_url = null;
    private string $created_at;
    private string | null $updated_at = null;
    private User $author;
    private array $comments = [];
    private array $likes = [];

    # CONSTRUCTOR

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

    # GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getHeroImageUrl(): ?string
    {
        return $this->hero_image_url;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @return Like[]
     */
    public function getLikes(): array
    {
        return $this->likes;
    }

    # SETTERS
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setAuthorId($author_id): void
    {
        $this->author_id = $author_id;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function setHeroImageUrl($hero_image_url): void
    {
        $this->hero_image_url = $hero_image_url;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @param Like[] $likes
     */
    public function setLikes(array $likes): void
    {
        $this->likes = $likes;
    }

    public function save(): void
    {
        if ($this->id == null) {
            $this->create();
        } else {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
            $this->update();
        }
    }
}
