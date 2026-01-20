<?php

namespace App\Models;

use Framework\Core\Model;

class User extends Model
{
    protected ?int $id = null;
    protected string $username;
    protected ?string $email = null;
    protected string $password_hash;
    protected ?string $created_at = null;

    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): ?string { return $this->email; }
    public function getPasswordHash(): string { return $this->password_hash; }

    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(?string $email): void { $this->email = $email; }
    public function setPasswordHash(string $hash): void { $this->password_hash = $hash; }
}