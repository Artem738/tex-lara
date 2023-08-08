<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purpose;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Получаем информацию о продуктах и связанных странах
        $products = Product::with('country', 'categories')->get();
        return view('products.index', compact('products'));
    }
        public function test()
    {
        // Получаем информацию о продуктах и связанных странах
//        $purpose = Purpose::find(2);
//        $products = $purpose->products;
//
//        $product = Product::find(2);
//        $purposes = $product->purposes;
    }


}
