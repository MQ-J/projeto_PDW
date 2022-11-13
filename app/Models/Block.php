<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ["user", "text", "menu"];

    public static function getByUserAndMenu(int $user, int $menu): Collection
    {
        return parent::where("user", "=", $user)
            ->where("menu", "=", $menu)->get();
    }

    public static function findByUserAndId(int $user, int $id): ?Block
    {
        return parent::where("user", "=", $user)
            ->where("id", "=", $id)->first();
    }
}
