<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $model;
    protected $categories;

    /**
     * ProductsController constructor.
     * @param Products $model
     * @param Categories $categories
     */

    function __construct(
        Products $model,
        Categories $categories
    )
    {
        $this->model = $model;
        $this->categories = $categories;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->model->query()->with('categories', 'offers')->get();
        $categories = $this->categories->query()->get()->unique('alias');

        return view('pages.products.index', compact('products', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {

        $attributes = $request->all();

        $products = $this->model->search($attributes);

        $result = view('pages.products.items', compact('products'))->render();

        return response()->json(['result'=>$result]);
    }
}
