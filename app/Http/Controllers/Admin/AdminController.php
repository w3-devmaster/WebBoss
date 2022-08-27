<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Billing;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function check( Request $request )
    {
        $request->validate( [
            'email'    => 'required|email|exists:admins,email',
            'password' => 'required|min:5|max:30',
        ], [
            'email.exists' => 'The email not found on the system',
        ] );

        $creds = $request->only( 'email', 'password' );
        if ( Auth::guard( 'admin' )->attempt( $creds, $request->has( 'remember' ) ) )
        {
            return redirect()->route( 'admin.index' )->with( 'success', 'Admin is logged on.' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'Failed to login.' );
        }
    }

    public function changepassword( Request $request )
    {
        $request->validate( [
            'password'       => 'required',
            'new_password'   => 'required|min:5|max:30',
            'renew_password' => 'required|min:5|max:30|same:new_password',
        ] );

        $admin = Admin::where( 'id', Auth::guard( 'admin' )->user()->id )->first();
        if ( !Hash::check( $request->password, $admin->password ) )
        {
            return redirect()->back()->with( 'fail', 'รหัสผ่านปัจจุบันไม่ถูกต้อง' );
        }

        $admin->password = Hash::make( $request->new_password );
        $admin->save();

        return redirect()->back()->with( 'success', 'เปลี่ยนรหัสผ่านเสร็จสิ้น' );

    }

    public function logout()
    {
        Auth::guard( 'admin' )->logout();

        return redirect()->route( 'admin.login' );
    }

    public function order_list()
    {
        $billing        = Billing::where( ['order_status' => 1, 'bill_status' => 1] )->get();
        $billing_accept = Billing::where( 'order_status', '<', 3 )->where( 'order_status', '>', 1 )->where( 'bill_status', '<=', 2 )->get();

        return view( 'admin.pages.order-list', compact( 'billing', 'billing_accept' ) );
    }

    public function order_success()
    {
        $billing = Billing::where( 'order_status', '>=', 3 )->where( 'bill_status', '>=', 2 )->get();

        return view( 'admin.pages.order-success', compact( 'billing' ) );
    }

    public function order_view( Billing $order )
    {
        $billing = $order;

        return view( 'admin.pages.order-view', compact( 'billing' ) );
    }

    public function update_order( Request $request, Billing $order )
    {
        $order->bill_status  = $request->bill_status;
        $order->order_status = 2;
        $order->save();

        Receipt::create( [
            'user'         => $order->user,
            'code'         => genReceiptCode( $order->mode ),
            'billing'      => $order->id,
            'mode'         => $order->mode,
            'tax_id'       => $order->tax_id,
            'customer'     => $order->customer,
            'send_address' => $order->send_address,
            'product'      => $order->product,
        ] );

        return redirect()->route( 'admin.order-list' )->with( 'success', 'ดำเนินการเสร็จสิ้น' );
    }

    public function update_send( Request $request, Billing $order )
    {
        if ( $request->order_status == 3 )
        {
            $request->validate( [
                'sender'   => 'required|string',
                'tracking' => 'required|string',
            ] );

            $order->sender   = $request->sender;
            $order->tracking = $request->tracking;
        }

        $order->order_status = $request->order_status;
        $order->save();

        return redirect()->route( 'admin.order-list' )->with( 'success', 'ดำเนินการเสร็จสิ้น' );
    }
}