<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryCategory extends Model
{
    use HasFactory;

    public function secondaries()
    {
        return $this->hasMany(SecondaryCategory::class, SecondaryCategory::FOREIGN_KEY);
    }
}
