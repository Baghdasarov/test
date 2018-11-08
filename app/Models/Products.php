<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'description',
        'first_invoice',
        'url',
        'price',
        'amount',
    ];

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function search($attributes)
    {
        $products = $this->query();
        if (isset($attributes['search']) && $attributes['search'])
        {
            $term = $attributes['search'];
            $products = $products->where(function ($q) use ($term){
                $q->where('title', 'LIkE', '%'.$term.'%')
                    ->orWhere('description', 'LIkE', '%'.$term.'%');
            });
        }

        if (isset($attributes['category']) && $attributes['category'])
        {
            $alias = $attributes['category'];
            $products = $products->wherehas('categories', function ($q) use ($alias){
               $q->where('alias', $alias);
            });

        }

        return $products->get();
    }


    /**
     * Relations Has Many
     */
    public function categories()
    {
        return $this->hasMany(Categories::class, 'product_id');
    }

    public function offers()
    {
        return $this->hasMany(Offers::class, 'product_id');
    }
}
