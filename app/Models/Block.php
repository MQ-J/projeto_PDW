<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = ["user", "text", "menu"];
}
