<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use HasFactory;

    public static function findById(int $id): ?static
    {
        return parent::where("id", "=", $id)->first();
    }
}
