<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

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
        if ( !Schema::hasColumn( 'settings', 'tax_id' ) )
        {
            Artisan::call( 'migrate' );
        }

        $request->validate( [
            'company_name'  => 'required|string',
            'tax_id'        => 'required|numeric|digits:13',
            'address'       => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'line'          => 'required|string',
            'facebook'      => 'required|string|url',
            'before_footer' => 'required|string',
        ] );

        $setting                = Setting::find( 1 );
        $setting->company_name  = $request->company_name;
        $setting->tax_id        = $request->tax_id;
        $setting->address       = $request->address;
        $setting->email         = $request->email;
        $setting->phone         = $request->phone;
        $setting->line          = $request->line;
        $setting->facebook      = $request->facebook;
        $setting->before_footer = $request->before_footer;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จสิ้น' );

    }

    /// Bank
    public function bank()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.bank', compact( 'setting' ) );
    }

    public function bank_exec( Request $request )
    {
        $request->validate( [
            'image'   => 'required|url',
            'bank'    => 'required|string',
            'account' => 'required|numeric',
            'name'    => 'required|string',
        ] );

        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        $data = [
            'image'   => $request->image,
            'bank'    => $request->bank,
            'account' => $request->account,
            'name'    => $request->name,
        ];

        if ( $setting->bank == null )
        {
            $datas = [];
        }
        else
        {
            $datas = array_combine( range( 1, count( json_decode( $setting->bank, true ) ) ), array_values( json_decode( $setting->bank, true ) ) );
        }

        $cnt = count( $datas ) + 1;

        $datas[$cnt] = $data;

        $setting->bank = json_encode( $datas );

        // dd( $setting->bank );
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จสิ้น' );
    }

    public function bank_delete( Request $request )
    {

        $setting = Setting::find( 1 );
        $datas   = json_decode( $setting->bank, true );

        unset( $datas[$request->key] );

        $data = array_combine( range( 1, count( $datas ) ), array_values( $datas ) );

        $setting->bank = json_encode( $data );

        $setting->save();

        return redirect()->back()->with( 'success', 'ลบข้อมูลเสร็จสิ้น' );
    }

    // How to buy
    public function how_to_buy()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.how-to-buy', compact( 'setting' ) );
    }

    public function how_to_buy_exec( Request $request )
    {
        $setting                = Setting::find( 1 );
        $setting->page_howtobuy = $request->page_howtobuy;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // How to payment
    public function how_to_payment()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.how-to-payment', compact( 'setting' ) );
    }

    public function how_to_payment_exec( Request $request )
    {
        $setting                    = Setting::find( 1 );
        $setting->page_howtopayment = $request->page_howtopayment;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // About
    public function about()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.about', compact( 'setting' ) );
    }

    public function about_exec( Request $request )
    {
        $setting             = Setting::find( 1 );
        $setting->page_about = $request->page_about;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // Contact
    public function contact()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.contact', compact( 'setting' ) );
    }

    public function contact_exec( Request $request )
    {
        $setting               = Setting::find( 1 );
        $setting->page_contact = $request->page_contact;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // Privacy Policy
    public function privacy_policy()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.privacy-policy', compact( 'setting' ) );
    }

    public function privacy_policy_exec( Request $request )
    {
        $setting                 = Setting::find( 1 );
        $setting->privacy_policy = $request->privacy_policy;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // Refund Policy
    public function refund_policy()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.refund-policy', compact( 'setting' ) );
    }

    public function refund_policy_exec( Request $request )
    {
        $setting                = Setting::find( 1 );
        $setting->refund_policy = $request->refund_policy;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }

    // Product Policy
    public function product_policy()
    {
        if ( !Setting::whereId( 1 )->exists() )
        {
            Setting::create();
        }

        $setting = Setting::find( 1 );

        return view( 'admin.pages.product-policy', compact( 'setting' ) );
    }

    public function product_policy_exec( Request $request )
    {
        $setting                 = Setting::find( 1 );
        $setting->product_policy = $request->product_policy;
        $setting->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเรียบร้อยแล้ว' );
    }
}