<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Billing;
use App\Models\Category;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Setting;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $data             = [];
        $data['bill'][1]  = Billing::where( 'bill_status', 1 )->count();
        $data['bill'][2]  = Billing::where( 'bill_status', 2 )->count();
        $data['order'][2] = Billing::where( 'order_status', 2 )->count();
        $data['order'][3] = Billing::where( 'order_status', 3 )->count();
        $data['cancel']   = Billing::where( 'order_status', 4 )->orWhere( 'bill_status', 3 )->count();

        // dd( $data );

        return view( 'admin.index', compact( 'data' ) );
    }

    public function dashboard()
    {
        $resp = Billing::select(
            DB::raw( 'sum(price) as sums' ),
            DB::raw( "DATE_FORMAT(created_at,'%M %Y') as months" )
        )->where( ['bill_status' => 2] )->groupBy( 'months' )->get();
        $data = [];
        foreach ( $resp as $key => $value )
        {
            $data[$value->months] = $value->sums;
        }

        return view( 'admin.dashboard', compact( 'data' ) );
    }

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
        $po             = Billing::where( ['order_status' => 0, 'bill_status' => 0] )->get();
        $billing        = Billing::where( ['order_status' => 1, 'bill_status' => 1] )->get();
        $billing_accept = Billing::where( 'order_status', '<', 3 )->where( 'order_status', '>', 1 )->where( 'bill_status', '<=', 2 )->get();
        $billing_cancel = Billing::where( 'bill_status', 3 )->get();

        return view( 'admin.pages.order-list', compact( 'po', 'billing', 'billing_accept', 'billing_cancel' ) );
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
        if ( !Schema::hasColumns( 'receipts', ['discount', 'dis_price'] ) )
        {
            Artisan::call( 'migrate' );
        }

        $order->bill_status = $request->bill_status;
        if ( $request->bill_status == 3 )
        {
            $order->order_status = 5;
            Storage::delete( $order->payment );
            $order->payment = null;

            foreach ( json_decode( $order->product, true ) as $value )
            {
                $amount = (Int) $value['amount'];
                $p      = Product::where( 'code', $value['code'] )->first();
                $p->increment( 'amount', $amount );
                $p->decrement( 'buy', $amount );
            }
        }
        else
        {
            $order->order_status = 2;
        }
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
            'discount'     => $order->discount,
            'dis_price'    => $order->dis_price,
        ] );

        return redirect()->route( 'admin.order-list' )->with( 'success', 'ดำเนินการเสร็จสิ้น' );
    }

    public function update_discount( Request $request, Billing $order )
    {
        if ( !Schema::hasColumns( 'receipts', ['discount', 'dis_price'] ) )
        {
            Artisan::call( 'migrate' );
        }

        $order->discount  = $request->discount;
        $order->dis_price = $request->dis_price;
        $order->save();

        return redirect()->route( 'admin.order', $order->id )->with( 'success', 'ดำเนินการเสร็จสิ้น' );
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

        if ( $request->order_status == 4 )
        {
            foreach ( json_decode( $order->product, true ) as $value )
            {
                $amount = (Int) $value['amount'];
                $p      = Product::where( 'code', $value['code'] )->first();
                $p->increment( 'amount', $amount );
                $p->decrement( 'buy', $amount );
            }
        }

        return redirect()->route( 'admin.order-list' )->with( 'success', 'ดำเนินการเสร็จสิ้น' );
    }

    public function customers()
    {
        $customers = User::all();

        return view( 'admin.pages.customers', compact( 'customers' ) );
    }

    public function customer( $id )
    {
        $customer = User::whereId( $id )->first();

        return view( 'admin.pages.customer', compact( 'customer' ) );
    }

    public function create_test_data( Request $request )
    {
        $faker = Factory::create();
        if ( $request->mode == 1 )
        {
            $setting                = Setting::find( 1 );
            $setting->company_name  = $faker->name();
            $setting->address       = $faker->address();
            $setting->email         = $faker->email();
            $setting->phone         = $faker->phoneNumber();
            $setting->line          = $faker->text( 10 );
            $setting->facebook      = $faker->url();
            $setting->before_footer = $faker->text( 500 );
            $setting->save();

            return redirect()->back()->with( 'success', 'ดำเนินการเสร็จสิ้น' );
        }
        else
        {
            $request->validate( [
                'amount' => 'required|numeric|min:1',
            ] );

            if ( $request->mode == 2 )
            {
                for ( $i = 1; $i <= $request->amount; $i++ )
                {
                    Category::factory()->create();
                }

                return redirect()->back()->with( 'success', 'ดำเนินการเสร็จสิ้น' );
            }
            elseif ( $request->mode == 3 )
            {
                for ( $i = 1; $i <= $request->amount; $i++ )
                {
                    Product::factory()->create();
                }

                return redirect()->back()->with( 'success', 'ดำเนินการเสร็จสิ้น' );
            }
        }
    }

    public function reset_data( Request $request )
    {
        Artisan::call( 'migrate:fresh --seed' );

        return redirect()->back()->with( 'success', 'เข้!! ล้างข้อมูลหมดแล้ว ไม่เหลืออะไรเลย' );
    }
}