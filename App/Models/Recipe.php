<?php

namespace App\Models;

use Framework\Core\Model;

class Recipe extends Model
{
    protected ?int $id = null;
    protected int $user_id;
    protected string $title;
    protected ?string $description = null;
    protected string $instructions;
    protected ?int $prep_time = null;
    protected ?int $servings = null;
    protected string $difficulty = 'easy';
    protected int $is_public = 1;
    protected ?string $created_at = null;

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): ?string { return $this->description; }
    public function getInstructions(): string { return $this->instructions; }
    public function getPrepTime(): ?int { return $this->prep_time; }
    public function getServings(): ?int { return $this->servings; }
    public function getDifficulty(): string { return $this->difficulty; }
    public function isPublic(): bool { return (int)$this->is_public === 1; }

    public function setUserId(int $userId): void { $this->user_id = $userId; }
    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setInstructions(string $instructions): void { $this->instructions = $instructions; }
    public function setPrepTime(?int $v): void { $this->prep_time = $v; }
    public function setServings(?int $v): void { $this->servings = $v; }
    public function setDifficulty(string $v): void { $this->difficulty = $v; }
    public function setPublic(bool $isPublic): void { $this->is_public = $isPublic ? 1 : 0; }
}