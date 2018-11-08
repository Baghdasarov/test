<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'title',
        'alias',
        'parent',
    ];
}
