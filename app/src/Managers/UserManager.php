<?php

namespace App\Managers;

use App\Entities\Role;
use App\Entities\User;
use App\Helpers\Regex;
use App\Managers\Exceptions\UserException;

class UserManager extends BaseManager
{
    # DATABASE METHODS

    /**
     * @param int $id
     * @return User
     * @throws UserException
     */
    public function getUserById(int $id): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @throws UserException
     */
    public function getUserByAuthenticationMethod(string $value): User
    {
        if (Regex::validateEmail($value)) {
            return $this->getUserByEmail($value);
        } else if (Regex::validatePhone($value)) {
            return $this->getUserByPhone($value);
        } else {
            return $this->getUserByUsername($value);
        }
    }

    /**
     * @param string $email
     * @return User
     * @throws UserException
     */
    public function getUserByEmail(string $email): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(":email", $email);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @param string $username
     * @return User
     * @throws UserException
     */
    public function getUserByUsername(string $username): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query);
        $statement->bindValue(":username", $username);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @param string $phone
     * @return User
     * @throws UserException
    */
    public function getUserByPhone(string $phone): User
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE phone = :phone";
        $statement = $db->prepare($query);
        $statement->bindValue(":phone", $phone);
        $statement->execute();
        $data = $statement->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new User($data);
        } else {
            throw new UserException("User not found");
        }
    }

    /**
     * @param int|null $i
     * @return User[]
     */
    public function getAllUsers(int $i = null): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users ORDER BY id ASC";
        $statement = $db->prepare($query);
        $statement->execute();
        $users = [];
        $k = 0;
        if ($i == null) {
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = new User($data);
            }
        } else {
            while (($data = $statement->fetch(\PDO::FETCH_ASSOC)) && ($k < $i)) {
                $users[] = new User($data);
                $k++;
            }
        }
        return $users;
    }

    /**
     * @param int $id
     * @return User[]
     */
    public function getUserFollowers(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE id IN (SELECT follower_user_id FROM user_follows WHERE followed_user_id = :id)";
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
     * @param int $id
     * @return User[]
     */
    public function getUserFollowings(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM users WHERE id IN (SELECT followed_user_id FROM user_follows WHERE follower_user_id = :id)";
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
     * @param int $id
     * @return Role[]
     */
    public function getUserRoles(int $id): array
    {
        $db = $this->pdo;
        $query = "SELECT * FROM roles WHERE id IN (SELECT role_id FROM user_roles WHERE user_id = :id)";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();

        $roles = [];
        while ($data = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $roles[] = new Role($data);
        }
        return $roles;
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    public function createUser(User $user): User
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            INSERT INTO users (email, username, phone, hashed_password, firstname, lastname, date_of_birth, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $request->execute(array(
                $user->getEmail(),
                $user->getUsername(),
                $user->getPhone(),
                $user->getHashedPassword(),
                $user->getFirstname(),
                $user->getLastname(),
                $user->getDateOfBirth(),
                $user->getCreatedAt(),
                $user->getUpdatedAt()
            ));
            $user->setId($db->lastInsertId());
            return $user;
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                throw new UserException("Email or username already exists");
            } else {
                throw new UserException($e->getMessage());
            }
        }
    }

    /**
     * @param User $user
     * @return User
     * @throws UserException
     */
    public function updateUser(User $user): User
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            UPDATE users
            SET email = ?, username = ?, phone = ?, bio = ?, hashed_password = ?, firstname = ?, lastname = ?, date_of_birth = ?, updated_at = ?
            WHERE id = ?;");

            $request->execute(array(
                $user->getEmail(),
                $user->getUsername(),
                $user->getPhone(),
                $user->getBio(),
                $user->getHashedPassword(),
                $user->getFirstname(),
                $user->getLastname(),
                $user->getDateOfBirth(),
                $user->getUpdatedAt(),
                $user->getId()
            ));
            return $user;
        } catch (\Exception $e) {
            throw new UserException("An error occurred while updating the user");
        }
    }

    /**
     * @param User $user
     * @return void
     * @throws UserException
     */
    public function deleteUser(User $user): void
    {
        try {
            $db = $this->pdo;
            $request = $db->prepare("
            DELETE FROM users
            WHERE id = ?;");
            $request->execute(array($user->getId()));
        } catch (\Exception $e) {
            throw new UserException("An error occurred while deleting the user");
        }
    }
}
