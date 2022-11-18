<?php

namespace App\Entities;

class Role extends BaseEntity {
    private int $id;
    private string $name;
    private ?string $description = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /*======= SETTERS =======*/
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /*======= GETTERS =======*/
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
}