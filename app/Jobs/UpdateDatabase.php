<?php

namespace App\Jobs;

use App\Models\Categories;
use App\Models\Offers;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class UpdateDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $json = file_get_contents("https://markethot.ru/export/bestsp");
        $results = json_decode($json)->products;

        $products = [];
        $categories = [];
        $offers = [];
        foreach ($results as $product)
        {
            $product = (array)$product;

            $productOffers = $product['offers'];
            $productCategories = $product['categories'];

            foreach ($productOffers as $offer)
            {
                $offers[] = [
                    'id' => $offer->id,
                    'product_id' => $product['id'],
                    'price' => $offer->price,
                    'amount' => $offer->amount,
                    'sales' => $offer->sales,
                    'article' => $offer->article,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            foreach ($productCategories as $category)
            {
                $categories[] = [
                    'id' => $category->id,
                    'product_id' => $product['id'],
                    'title' => $category->title,
                    'alias' => $category->alias,
                    'parent' => $category->parent,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            $products[] = [
                    'id' => $product['id'],
                    'title' => $product['title'],
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'first_invoice' => $product['first_invoice'],
                    'url' => $product['url'],
                    'price' => $product['price'],
                    'amount' => $product['amount'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
        }

        DB::transaction(function () use ($products, $offers, $categories){
            Products::query()->delete();
            Offers::query()->delete();
            Categories::query()->delete();

            Products::query()->insert($products);
            Offers::query()->insert($offers);
            Categories::query()->insert($categories);
        });
    }
}
