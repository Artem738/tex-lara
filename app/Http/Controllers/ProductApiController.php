<?php

namespace App\Http\Controllers;

use App\Http\DTO\ProductIndexDto;
use App\Http\Requests\ProductApi\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    protected APIProductService $service;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndexRequest $request)
    {
        $valid = $request->validated();

        $dto = new ProductIndexDto(
            $valid['category'] ?? null,
            $valid['fabric'] ?? null,
            $valid['tone'] ?? null,
            $valid['pattern'] ?? null,
            $valid['country_id'] ?? null,
            $valid['purpose'] ?? null,
            $valid['lastId'] ?? null,
        );
        var_dump($dto);
        die();


//        $dto = new BookIndexDTO(
//            new Carbon($validatedData['startDate']),
//            new Carbon($validatedData['endDate']),
//            $validatedData['year'] ?? null,
//            LangEnum::tryFrom($validatedData['lang'] ?? null),// Довго розбирався, запрацювало...
//            $validatedData['lastId'] ?? 0,
//            LimitEnum::tryFrom($validatedData['limit'] ?? LimitEnum::LIMIT_20->value),
//        );


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

        //dd($product->categorie);

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
