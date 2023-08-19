<?php

namespace App\Http\Controllers;

use App\Http\DTO\ProductIndexDto;
use App\Http\Requests\ProductApi\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Http\Services\ProductApiService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function __construct(
        protected ProductApiService $service
    ) {
    }

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
            $valid['prod_status'] ?? null,
        );

        $products = $this->service->getIndexProducts($dto);

        //$resource = BookResource::collection($books);

      //  var_dump($products);
      //  die();





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
