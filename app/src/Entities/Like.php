<?php

namespace App\Entities;

class Like extends BaseEntity
{
    protected int $id;
    protected User $user;
    protected ?string $createdAt;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}