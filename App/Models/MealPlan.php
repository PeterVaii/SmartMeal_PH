<?php

namespace App\Models;

use Framework\Core\Model;

class MealPlan extends Model
{
    protected ?int $id = null;
    protected int $user_id;
    protected int $recipe_id;
    protected string $day;
    protected ?string $created_at = null;

    public static function getTableName(): string
    {
        return 'meal_plans';
    }

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getRecipeId(): int { return $this->recipe_id; }
    public function getDay(): string { return $this->day; }

    public function setUserId(int $v): void { $this->user_id = $v; }
    public function setRecipeId(int $v): void { $this->recipe_id = $v; }
    public function setDay(string $v): void { $this->day = $v; }
}