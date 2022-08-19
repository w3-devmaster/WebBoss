<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas    = [];
        $category = Category::whereLevel( 0 )->get();

        // foreach ( $category as $key => $value )
        // {
        //     $datas[$value->id] = [
        //         "id"         => $value->id,
        //         "name"       => $value->name,
        //         "img"        => $value->img,
        //         "level"      => $value->level,
        //         "parent"     => $value->parent,
        //         "created_at" => $value->created_at,
        //         "updated_at" => $value->updated_at,
        //         'child'      => getCategoryChildByParent( $value->id ),
        //     ];
        // }

        // dd( $datas );

        return view( 'admin.pages.category.index', compact( 'category' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();

        return view( 'admin.pages.category.create', compact( 'category' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreCategoryRequest $request )
    {
        if ( $request->parent == 0 )
        {
            $level = 0;
        }
        else
        {
            $level = Category::find( $request->parent )->level + 1;
        }

        if ( $level > 3 )
        {
            return redirect()->back()->with( 'fail', 'ไม่ควรซ้อนหมวดหมู่เกิน 3 ระดับ' );
        }

        $img  = $request->file( 'img' );
        $path = $img->storeAs( 'public/category', md5( rand() . uniqid() ) . '-' . $img->getClientOriginalName() );

        $category = Category::create( [
            'name'   => $request->name,
            'img'    => $path,
            'level'  => $level,
            'parent' => $request->parent,
        ] );

        if ( !$category )
        {
            return redirect()->back()->with( 'fail', 'มีบางอย่างผิดพลาด' );
        }

        return redirect()->back()->with( 'success', 'เพิ่มหมวดหมู่เสร็จสิ้น' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show( Category $category )
    {
        $cat = Category::all();

        return view( 'admin.pages.category.show', compact( 'category', 'cat' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit( Category $category )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateCategoryRequest $request, Category $category )
    {
        if ( $request->parent == 0 )
        {
            $level = 0;
        }
        else
        {
            $level = Category::find( $request->parent )->level + 1;
        }

        if ( $level > 3 )
        {
            return redirect()->back()->with( 'fail', 'ไม่ควรซ้อนหมวดหมู่เกิน 3 ระดับ' );
        }

        if ( $request->hasFile( 'img' ) )
        {
            $img  = $request->file( 'img' );
            $path = $img->storeAs( 'public/category', md5( rand() . uniqid() ) . '-' . $img->getClientOriginalName() );
            Storage::delete( $category->img );

            $category->img = $path;
        }

        $category->name   = $request->name;
        $category->parent = $request->parent;
        $category->level  = $level;
        $category->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จสิ้น' );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( Category $category )
    {
        Storage::delete( $category->img );
        $category->delete();

        return redirect()->route( 'admin.category.index' )->with( 'success', 'ลบข้อมูลเสร็จสิ้น' );
    }
}