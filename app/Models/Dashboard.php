<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    /**
     * @param $products
     * @param $attributes
     * @return mixed
     */
    public function search($products, $attributes)
    {
        if (isset($attributes['search']) && $attributes['search'])
        {
            $products = $products->filter(function ($item) use ($attributes) {
                return stristr($item->title, $attributes['search']) !== false || stristr($item->description, $attributes['search']);
            });
        }

        if (isset($attributes['category']) && $attributes['category'])
        {
            $categories = $this->categories($products, true);

            $productIDs = collect($categories)->filter(function ($item) use ($attributes) {
                return stristr($item['alias'], $attributes['category']) !== false;
            })->pluck('product_id');

            $products = $products->filter(function ($item) use ($productIDs) {
                return in_array($item->id, $productIDs->toArray());
            });
        }

        return $products;
    }

    public function categories($products, $parentID = false)
    {
        $categories = [];
        foreach ($products as $product)
        {
            foreach ($product->categories as $category)
            {
                if ($parentID) {
                    $arrCategory = (array)$category;
                    $arrCategory['product_id'] = $product->id;
                    $categories[] = $arrCategory;
                } else {
                    $categories[$category->alias] = $category->title;
                }
            }
        }

        return $categories;
    }
}
