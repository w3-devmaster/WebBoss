<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view( 'user.index' );
    }

    public function update_user( Request $request )
    {
        $request->validate( [
            'tax_id'                    => 'required|numeric|digits:13',
            'phone'                     => 'required|numeric|digits:10',
            'tax_address.phone'         => 'required|string|digits_between:9,10',
            'tax_address.address'       => 'required|string',
            'tax_address.sub_district'  => 'required|string',
            'tax_address.district'      => 'required|string',
            'tax_address.province'      => 'required|string',
            'tax_address.postcode'      => 'required|numeric|digits:5',
            'send_address.phone'        => 'required|string|digits_between:9,10',
            'send_address.address'      => 'required|string',
            'send_address.sub_district' => 'required|string',
            'send_address.district'     => 'required|string',
            'send_address.province'     => 'required|string',
            'send_address.postcode'     => 'required|numeric|digits:5',
        ] );

        $user                  = Auth::guard( 'web' )->user()->id;
        $account               = User::whereId( $user )->first();
        $account->tax_id       = $request->tax_id;
        $account->phone        = $request->phone;
        $account->send_address = json_encode( $request->send_address );
        $account->tax_address  = json_encode( $request->tax_address );
        $account->save();

        return redirect()->back()->with( 'success', 'บันทึกข้อมูลเสร็จสิ้น' );

    }

    public function changepassword( Request $request )
    {
        $request->validate( [
            'password'       => 'required',
            'new_password'   => 'required|min:5|max:30',
            'renew_password' => 'required|min:5|max:30|same:new_password',
        ] );

        $user = User::where( 'id', Auth::guard( 'web' )->user()->id )->first();
        if ( !Hash::check( $request->password, $user->password ) )
        {
            return redirect()->back()->with( 'fail', 'รหัสผ่านปัจจุบันไม่ถูกต้อง' );
        }

        $user->password = Hash::make( $request->new_password );
        $user->save();

        return redirect()->back()->with( 'success', 'เปลี่ยนรหัสผ่านเสร็จสิ้น' );

    }

    public function billing()
    {
        $user    = Auth::guard( 'web' )->user()->id;
        $billing = Billing::whereUser( $user )->orderByDesc( 'updated_at' )->paginate( 25 );

        return view( 'user.billing', compact( 'billing' ) );
    }

    public function billing_info( $id )
    {
        $user    = Auth::guard( 'web' )->user()->id;
        $billing = Billing::whereId( $id )->first();

        if ( $user != $billing->user )
        {
            return redirect()->route( 'user.billing' );
        }

        return view( 'user.billing-info', compact( 'billing' ) );
    }

    public function payment( Request $request )
    {
        $request->validate( [
            'id'      => 'required|numeric',
            'payment' => 'required|image|max:2048',
        ] );

        $billing = Billing::whereId( $request->id )->first();

        $image                 = $request->file( 'payment' );
        $path                  = $image->storeAs( 'public/payment', $billing->code . '-' . md5( rand() . uniqid() ) . '-' . $image->getClientOriginalName() );
        $billing->payment      = $path;
        $billing->order_status = 1;
        $billing->bill_status  = 1;
        $billing->save();

        return redirect()->back()->with( 'success', 'แจ้งชำระเงินเสร็จสิ้น' );
    }
}