<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class APIProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();


        return response()->json(
            [
                'data' => ProductResource::collection($products),
                'Bearer' => '',
                'meta' => [
                    'info' => '',
                ],
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       // print($id); die();
        $product = Product::findOrFail($id);

        //print($product->good_url).PHP_EOL;
        return response()->json(
            [
                'data' => new ProductResource($product),
                'Bearer' => '',
                'meta' => [
                    'info' => '',
                ],
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
