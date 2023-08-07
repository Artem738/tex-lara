<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Получаем информацию о продуктах и связанных странах
        $products = Product::with('country')->get();

        return view('products.index', compact('products'));
    }
}
