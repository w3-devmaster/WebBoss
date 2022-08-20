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

    public function product_list( $id )
    {
        $product       = Product::find( $id );
        $other_product = Product::inRandomOrder()->whereCategory( $product->category )->limit( 24 )->get();

        return view( 'pages.product-list', compact( 'product', 'other_product' ) );
    }

    public function product( $order = null, $asc = true )
    {
        if ( $order == null )
        {
            $product = Product::paginate( 36 );
        }
        else
        {
            if ( $asc )
            {
                $product = Product::orderBy( $order )->paginate( 36 );
            }
            else
            {
                $product = Product::orderByDesc( $order )->paginate( 36 );
            }
        }

        return view( 'pages.product', compact( 'product' ) );
    }

    public function category( $id, $order = null, $asc = true )
    {
        if ( $order == null )
        {
            $product = Product::whereCategory( $id )->paginate( 36 );
        }
        else
        {
            if ( $asc )
            {
                $product = Product::whereCategory( $id )->orderBy( $order )->paginate( 36 );
            }
            else
            {
                $product = Product::whereCategory( $id )->orderByDesc( $order )->paginate( 36 );
            }
        }

        $category = $id;

        return view( 'pages.category', compact( 'product', 'category' ) );
    }

}