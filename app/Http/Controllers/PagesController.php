<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class PagesController extends Controller
{
    public function index()
    {
        $product_sale  = Product::inRandomOrder()->where( 'discount', '>', 0 )->limit( 12 )->get();
        $product_hot   = Product::where( 'amount', '>', 0 )->orderByDesc( 'buy' )->limit( 12 )->get();
        $main_category = Category::whereLevel( 0 )->get();

        return view( 'pages.index', compact( 'main_category', 'product_sale', 'product_hot' ) );
    }

}