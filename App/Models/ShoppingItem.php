<?php

namespace App\Models;

use Framework\Core\Model;

class ShoppingItem extends Model
{
    protected ?int $id = null;
    protected int $user_id;
    protected string $name;
    protected ?string $unit = null;
    protected int $is_checked = 0;

    public static function getTableName(): string
    {
        return 'shopping_items';
    }

    public function getUserId(): int { return $this->user_id; }
    public function getName(): string { return $this->name; }
    public function getUnit(): ?string { return $this->unit; }
    public function isChecked(): bool { return (bool)$this->is_checked; }

    public function setUserId(int $v): void { $this->user_id = $v; }
    public function setName(string $v): void { $this->name = $v; }
    public function setUnit(?string $v): void { $this->unit = $v; }
    public function setChecked(bool $v): void { $this->is_checked = $v ? 1 : 0; }
}