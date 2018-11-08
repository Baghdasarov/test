<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'price',
        'amount',
        'sales',
        'article',
    ];
}
