<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_stocks';

    protected $fillable = [
        'productId',
        'type',
        'quantity',
    ];

    public const FOREIGN_KEY = 'productId';

    public function product()
    {
        return $this->belongsTo(Product::class, self::FOREIGN_KEY);
    }
}
