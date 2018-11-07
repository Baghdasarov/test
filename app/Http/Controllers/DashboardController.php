<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $model;

    /**
     * DashboardController constructor.
     * @param Dashboard $model
     */
    function __construct(Dashboard $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $json = file_get_contents("https://markethot.ru/export/bestsp");
        $products = json_decode($json)->products;

        $categories = $this->model->categories($products);

        return view('pages.dashboard.index', compact('products', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {

        $attributes = $request->all();
        $json = file_get_contents("https://markethot.ru/export/bestsp");

        $products = $this->model->search(collect(json_decode($json)->products), $attributes);

        $result = view('pages.dashboard.products', compact('products'))->render();

        return response()->json(['result'=>$result]);
    }
}
