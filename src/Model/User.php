<?php

namespace App\Model;

use DateTime;

class User
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $password,
        private DateTime $createdAt
    ) {}
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
