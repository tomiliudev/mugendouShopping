<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    use HasFactory;

    public const FOREIGN_KEY = 'primaryId';

    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class, self::FOREIGN_KEY);
    }
}
