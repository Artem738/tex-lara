<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ApiResponseTrait;
use App\Http\Requests\ProductApi\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Http\Services\ProductApiService;
use App\Http\VO\ProductIndexVO;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductApiController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ProductApiService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductIndexRequest $request): Response
    {
        $valid = $request->validated();
        $productIndexVO = ProductIndexVO::fromArray($valid);
        $products = $this->service->getIndexProducts($productIndexVO);
        //$resource = BookResource::collection($books);
        return $this->createResponse(ProductResource::collection($products));
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
        $product = Product::findOrFail($id);
        return $this->createResponse(new ProductResource($product));
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
