<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownerId',
        'imageName',
    ];

    public const FOREIGN_KEY = 'ownerId';

    public function owner()
    {
        return $this->belongsTo(Owner::class, self::FOREIGN_KEY);
    }
}
