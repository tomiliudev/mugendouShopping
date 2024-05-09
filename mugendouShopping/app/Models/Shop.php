<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public const FOREIGN_KEY = 'ownerId';

    public function owner()
    {
        return $this->belongsTo(Owner::class, self::FOREIGN_KEY);
    }
}
