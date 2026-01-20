<?php

namespace App\Models;

use Framework\Core\Model;

class RecipeIngredient extends Model
{
    protected ?int $id = null;
    protected int $recipe_id;
    protected string $name;
    protected ?float $amount = null;
    protected ?string $unit = null;

    public static function getTableName(): string
    {
        return 'recipe_ingredients';
    }

    public function getId(): ?int { return $this->id; }
    public function getRecipeId(): int { return $this->recipe_id; }
    public function getName(): string { return $this->name; }
    public function getAmount(): ?float { return $this->amount; }
    public function getUnit(): ?string { return $this->unit; }

    public function setRecipeId(int $recipeId): void { $this->recipe_id = $recipeId; }
    public function setName(string $name): void { $this->name = $name; }
    public function setAmount(?float $amount): void { $this->amount = $amount; }
    public function setUnit(?string $unit): void { $this->unit = $unit; }
}