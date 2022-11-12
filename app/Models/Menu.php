<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ["user", "name", "permalink"];

    public static function findByPermalinkAndUser(string $permalink, int $user): ?Menu
    {
        return parent::where("permalink", "LIKE", $permalink)
            ->where("user", "=", $user)
            ->first();
    }

    public static function getByUserId(int $id):Collection
    {
        return parent::where("user", "=", $id)->get();
    }
}
