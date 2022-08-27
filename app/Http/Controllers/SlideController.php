<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlideRequest;
use App\Http\Requests\UpdateSlideRequest;
use App\Models\Slide;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slide = Slide::orderBy( 'status' )->get();

        return view( 'admin.pages.slide.index', compact( 'slide' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'admin.pages.slide.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSlideRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreSlideRequest $request )
    {
        $image = $request->file( 'image' );
        $path  = $image->storeAs( 'public/slide', md5( rand() . uniqid() ) . '-' . $image->getClientOriginalName() );

        Slide::create( [
            'position' => $request->position,
            'name'     => $request->name,
            'image'    => $path,
        ] );

        return redirect()->back()->with( 'success', 'เพิ่มข้อมูลเรียบร้อยแล้ว' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show( Slide $slide )
    {
        return view( 'admin.pages.slide.show', compact( 'slide' ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit( Slide $slide )
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSlideRequest  $request
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateSlideRequest $request, Slide $slide )
    {
        if ( $request->hasFile( 'image' ) )
        {
            Storage::delete( $slide->image );
            $image        = $request->file( 'image' );
            $path         = $image->storeAs( 'public/slide', md5( rand() . uniqid() ) . '-' . $image->getClientOriginalName() );
            $slide->image = $path;
        }

        $slide->name     = $request->name;
        $slide->position = $request->position;
        $slide->status   = $request->status;
        $slide->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จ' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy( Slide $slide )
    {
        Storage::delete( $slide->image );
        $slide->delete();

        return redirect()->back()->with( 'success', 'ลบข้อมูลเสร็จสิ้น' );
    }
}