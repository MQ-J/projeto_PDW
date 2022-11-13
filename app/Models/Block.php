<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ["user", "text", "menu"];

    public static function findByUserAndId(int $user, int $id): ?Block
    {
        return parent::where("user", "=", $user)
            ->where("id", "=", $id)->first();
    }
}
