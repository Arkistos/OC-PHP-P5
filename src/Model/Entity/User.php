<?php

namespace App\Model\Entity;

class User
{
    protected int $id;
    protected string $firstname;
    protected string $lastname;
    protected string $role;
    protected string $email;
    protected string $password;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
