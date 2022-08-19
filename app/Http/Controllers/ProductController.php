<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return view( 'admin.pages.product.index', compact( 'product' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();

        return view( 'admin.pages.product.create', compact( 'category' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreProductRequest $request )
    {
        $image  = $request->file( 'image' );
        $path   = $image->storeAs( 'public/product/' . $request->code, md5( rand() . uniqid() ) . '-' . $image->getClientOriginalName() );
        $images = [];
        if ( $request->hasFile( 'images' ) )
        {
            foreach ( $request->images as $key => $img )
            {
                $p        = $img->storeAs( 'public/product/' . $request->code, md5( rand() . uniqid() ) . '-' . $img->getClientOriginalName() );
                $images[] = $p;
            }
        }

        $product = Product::create( [
            'code'            => $request->code,
            'product_name'    => $request->product_name,
            'product_details' => $request->product_details,
            'color'           => $request->color,
            'category'        => $request->category,
            'amount'          => $request->amount,
            'price'           => $request->price,
            'discount'        => $request->discount,
            'dis_price'       => $request->dis_price,
            'remain'          => $request->remain,
            'image'           => $path,
            'images'          => json_encode( $images ),
        ] );

        if ( $product )
        {
            return redirect()->back()->with( 'success', 'เพิ่ม ' . $product->product_name . ' เรียบร้อยแล้ว' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'เพิ่มสินค้าล้มเหลว' );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show( Product $product )
    {
        $category = Category::all();

        return view( 'admin.pages.product.show', compact( 'product', 'category' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit( Product $product )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateProductRequest $request, Product $product )
    {
        if ( $request->hasFile( 'image' ) )
        {
            Storage::delete( $product->image );
            $image          = $request->file( 'image' );
            $path           = $image->storeAs( 'public/product/' . $request->code, md5( rand() . uniqid() ) . '-' . $image->getClientOriginalName() );
            $product->image = $path;
        }

        if ( $request->hasFile( 'images' ) )
        {
            Storage::delete( json_decode( $product->images, true ) );
            $images = [];

            foreach ( $request->images as $key => $img )
            {
                $p        = $img->storeAs( 'public/product/' . $request->code, md5( rand() . uniqid() ) . '-' . $img->getClientOriginalName() );
                $images[] = $p;
            }
            $product->images = json_encode( $images );
        }

        $product->product_name    = $request->product_name;
        $product->product_details = $request->product_details;
        $product->color           = $request->color;
        $product->category        = $request->category;
        $product->amount          = $request->amount;
        $product->price           = $request->price;
        $product->discount        = $request->discount;
        $product->dis_price       = $request->dis_price;
        $product->remain          = $request->remain;

        if ( $product->save() )
        {
            return redirect()->back()->with( 'success', 'บันทึกข้อมูล ' . $product->product_name . ' เรียบร้อยแล้ว' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'บันทึกข้อมูลสินค้าล้มเหลว' );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy( Product $product )
    {
        //
    }
}