<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::all();

        return view( 'admin.pages.admin-manage.index', compact( 'admin' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'admin.pages.admin-manage.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $request->validate( [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ] );

        Admin::create( [
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'password'  => Hash::make( $request->password ),
            'type'      => 0,
        ] );

        return redirect()->back()->with( 'success', 'เพิ่มผู้ใช้เสร็จสิ้น' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $manage
     * @return \Illuminate\Http\Response
     */
    public function show( Admin $manage )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $manage
     * @return \Illuminate\Http\Response
     */
    public function edit( Admin $manage )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $manage
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Admin $manage )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $manage
     * @return \Illuminate\Http\Response
     */
    public function destroy( Admin $manage )
    {
        $manage->delete();

        return redirect()->back()->with( 'success', 'ลบผู้ใช้เสร็จสิ้น' );
    }
}