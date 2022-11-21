<?php

namespace App\Entities;

use App\Factories\PDOFactory;
use App\Managers\Exceptions\PostException;
use App\Managers\Exceptions\UserException;
use App\Managers\PostManager;
use App\Managers\UserManager;

class User extends BaseEntity {
    private ?int $id = null;
    private string $username = '';
    private string $email = '';
    private ?string $phone = null;
    private ?string $bio = null;
    private array $roles = [];
    private string $password = '';
    private string $firstname = '';
    private string $lastname = '';
    private ?string $date_of_birth = null;
    private ?string $avatar_url = null;
    private string $created_at;
    private string $updated_at;
    private array $followers = [];
    private array $followings = [];
    private array $posts = [];
    private array $comments = [];
    private array $likes = [];

    # CONSTRUCTORS
    public function __construct(array $data = [])
    {
        //        $this->roles = [new Role()];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

        parent::__construct($data);
    }
    public function __copy(User $user): User
    {
        $instance = new self();
        $instance->id = $user->getId();
        $instance->username = $user->getUsername();
        $instance->email = $user->getEmail();
        $instance->phone = $user->getPhone();
        $instance->bio = $user->getBio();
        $instance->roles = $user->getRoles();
        $instance->password = $user->getPassword();
        $instance->firstname = $user->getFirstname();
        $instance->lastname = $user->getLastname();
        $instance->date_of_birth = $user->getDateOfBirth();
        $instance->avatar_url = $user->getAvatarUrl();
        $instance->created_at = $user->getCreatedAt();
        $instance->updated_at = $user->getUpdatedAt();
        return $instance;
    }

    /*==================== SETTERS ====================*/
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setDateOfBirth(?string $date_of_birth): void
    {
        $this->date_of_birth = $date_of_birth;
    }

    public function setAvatarUrl(?string $avatar_url): void
    {
        $this->avatar_url = $avatar_url;
    }

    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /*==================== GETTERS ====================*/
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->date_of_birth;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /*====================*/
    public function passwordMatch(): bool
    {
        // TODO: Implement passwordMatch() method.
        return password_verify($this->password, PASSWORD_DEFAULT);
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        if (empty($this->roles)) {
            $manager = new UserManager(new PDOFactory());
            $this->roles = $manager->getUserRoles($this->getId());
        }
        return $this->roles;
    }

    public function userRolesContains(string $role): bool
    {
        foreach ($this->getRoles() as $userRole) {
            if ($userRole->getName() === $role) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return Post[]
     * @throws PostException
     */
    public function getPosts(): array
    {
        if (empty($this->posts)) {
            $manager = new PostManager(new PDOFactory());
            $this->posts = $manager->getPostByAuthorId($this->getId());
        }

        return $this->posts;
    }

    /**
     * @return User[]
     */
    public function getFollowers(): array
    {
        if (empty($this->followers)) {
            $manager = new UserManager(new PDOFactory());
            $this->followers = $manager->getUserFollowers($this->getId());
        }
        return $this->followers;
    }

    /**
     * @return User[]
     */
    public function getFollowings(): array
    {
        if (empty($this->followings)) {
            $manager = new UserManager(new PDOFactory());
            $this->followings = $manager->getUserFollowings($this->getId());
        }
        return $this->followings;
    }
}
