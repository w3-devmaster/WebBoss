<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.setting', compact( 'setting' ) );
    }

    public function save_setting( Request $request )
    {
        $request->validate( [
            'company_name'  => 'required|string',
            'address'       => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'line'          => 'required|string',
            'facebook'      => 'required|string|url',
            'before_footer' => 'required|string',
        ] );

        $setting                = Setting::find( 1 );
        $setting->company_name  = $request->company_name;
        $setting->address       = $request->address;
        $setting->email         = $request->email;
        $setting->phone         = $request->phone;
        $setting->line          = $request->line;
        $setting->facebook      = $request->facebook;
        $setting->before_footer = $request->before_footer;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จสิ้น' );

    }
}