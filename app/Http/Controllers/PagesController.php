<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PagesController extends Controller
{
    public function index()
    {
        $product_sale  = Product::inRandomOrder()->where( 'discount', '>', 0 )->limit( 12 )->get();
        $product_hot   = Product::where( 'amount', '>', 0 )->orderByDesc( 'buy' )->limit( 12 )->get();
        $main_category = Category::whereLevel( 0 )->get();
        $slide_main    = Slide::where( 'status', 1 )->where( 'position', 1 )->get();
        $slide_bl      = Slide::where( 'status', 1 )->where( 'position', 2 )->get();
        $slide_br      = Slide::where( 'status', 1 )->where( 'position', 3 )->get();

        return view( 'pages.index', compact( 'main_category', 'product_sale', 'product_hot', 'slide_main', 'slide_bl', 'slide_br' ) );
    }

    public function product_list( $id )
    {
        $product = Product::find( $id );
        $product->increment( 'view' );

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
        $cat_id            = [];
        $cat_id[(Int) $id] = 1;
        $cat               = Category::where( 'parent', $id )->get();
        foreach ( $cat as $value1 )
        {
            $cat_id[$value1->id] = 1;
            $cat1                = Category::where( 'parent', $value1->id )->get();
            foreach ( $cat1 as $value2 )
            {
                $cat_id[$value2->id] = 1;
                $cat2                = Category::where( 'parent', $value2->id )->get();
                foreach ( $cat2 as $value3 )
                {
                    $cat_id[$value3->id] = 1;
                    $cat3                = Category::where( 'parent', $value3->id )->get();
                    foreach ( $cat3 as $value4 )
                    {
                        $cat_id[$value4->id] = 1;
                    }
                }
            }

        }

        $where = [];
        foreach ( $cat_id as $key => $value )
        {
            $where[] = $key;
        }

        if ( $order == null )
        {

            $product = Product::whereIn( 'category', $where )->paginate( 36 );
        }
        else
        {
            if ( $asc )
            {
                $product = Product::whereIn( 'category', $where )->orderBy( $order )->paginate( 36 );
            }
            else
            {
                $product = Product::whereIn( 'category', $where )->orderByDesc( $order )->paginate( 36 );
            }
        }

        $category = $id;

        return view( 'pages.category', compact( 'product', 'category' ) );
    }

    public function store_cart( Request $request )
    {
        // $cart = session( 'cart' );
        if ( !session()->has( 'cart' ) )
        {
            session( ['cart' => []] );
        }
        $cart = session( 'cart' );

        if ( array_key_exists( $request->product, session( 'cart' ) ) )
        {
            $product = getProduct( $request->product );
            $all     = $cart[$request->product] + $request->amount;
            if ( $all > $product->amount )
            {
                $cart[$request->product] = $product->amount;
            }
            else
            {
                $cart[$request->product] += $request->amount;
            }
        }
        else
        {
            $product = getProduct( $request->product );
            if ( $request->amount > $product->amount )
            {
                $cart[$request->product] = $product->amount;
            }
            else
            {
                $cart[$request->product] = $request->amount;
            }
        }

        session( ['cart' => $cart] );

        // session()->forget( 'cart' );

        return response()->json( session( 'cart' ) );
    }

    public function edit_cart( Request $request )
    {
        $cart = session( 'cart' );

        if ( $request->amount <= 0 )
        {
            unset( $cart[$request->product] );
        }
        else
        {
            $product = getProduct( $request->product );
            if ( $request->amount > $product->amount )
            {
                $cart[$request->product] = $product->amount;
            }
            else
            {
                $cart[$request->product] = $request->amount;
            }
        }

        session( ['cart' => $cart] );

        // session()->forget( 'cart' );

        return response()->json( session( 'cart' ) );
    }

    public function del_cart( Request $request )
    {
        session()->forget( 'cart.' . $request->product, session( 'cart' ) );

        return response()->json( session( 'cart' ) );
    }

    public function clear_cart( Request $request )
    {
        session()->forget( 'cart' );

        return response()->json( session( 'cart' ) );
    }

    public function cart()
    {
        return view( 'pages.cart' );
    }

    public function register_payment( Request $request )
    {
        $request->validate( [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'phone'     => ['required', 'string', 'digits:10'],
        ] );

        User::create( [
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'phone'     => $request->phone,
            'email'     => $request->email,
            'password'  => Hash::make( $request->password ),
        ] );

        $creds = $request->only( 'email', 'password' );
        if ( Auth::guard( 'web' )->attempt( $creds ) )
        {
            return redirect()->route( 'cart' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'เกิดปัญหาบางอย่าง กรุณาเข้าสู่ระบบและดำเนินการอีกครั้ง' );
        }

    }

    public function login_payment( Request $request )
    {
        $request->validate( [
            'email'    => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.exists' => 'ไม่มีอีเมลนี้ในระบบ กรุณาตรวจสอบข้อมูลอีกครั้ง',
        ] );

        $creds = $request->only( 'email', 'password' );
        if ( Auth::guard( 'web' )->attempt( $creds, $request->boolean( 'remember' ) ) )
        {
            return redirect()->route( 'cart' );
        }
        else
        {
            return redirect()->back()->with( 'fail', 'เข้าสู่ระบบล้มเหลว กรุณาเข้าสู่ระบบและดำเนินการอีกครั้ง' );
        }

    }

    public function order_create( Request $request )
    {
        if ( !Schema::hasColumns( 'billings', ['discount', 'dis_price'] ) )
        {
            Artisan::call( 'migrate' );
        }

        $user      = Auth::guard( 'web' )->user()->id;
        $account   = User::whereId( $user )->first();
        $price_all = $request->price;
        if ( $request->billing == 2 )
        {
            $request->validate( [
                'tax_id' => 'required|numeric|digits:13',
            ] );
            $price_all = $request->price + ( $request->price * 0.07 );
        }

        $request->validate( [
            'billing'                   => 'required|numeric',
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

        $data = [];
        foreach ( session( 'cart' ) as $key => $value )
        {
            $product = getProduct( $key );
            if ( $product->discount == 0 )
            {
                $price = $product->price;
            }
            elseif ( $product->discount == 1 )
            {
                $price = $product->price - $product->dis_price;
            }
            elseif ( $product->discount == 2 )
            {
                $price = $product->price - ( $product->price * $product->dis_price ) / 100;
            }

            $data[] = [
                'code'         => $product->code,
                'product_name' => $product->product_name,
                'amount'       => $value,
                'price'        => $price,
            ];

        }

        $account->tax_id       = $request->tax_id;
        $account->send_address = json_encode( $request->send_address );
        $account->tax_address  = json_encode( $request->tax_address );
        $account->save();

        $billing = Billing::create( [
            'user'         => $user,
            'code'         => genBillingCode(),
            'mode'         => $request->billing,
            'tax_id'       => $request->tax_id,
            'customer'     => json_encode( $request->tax_address ),
            'send_address' => json_encode( $request->send_address ),
            'product'      => json_encode( $data ),
            'price'        => $price_all,
        ] );

        session()->forget( 'cart' );

        return redirect()->route( 'user.billing-info', $billing->id )->with( 'success', 'ดำเนินการเสร็จสิ้นกรุณาแจ้งชำระเงิน' );

    }

    public function search_product( Request $request )
    {
        if ( $request->data === null )
        {
            return redirect()->route( 'product' );
        }
        $product = Product::where( 'product_name', 'like', '%' . $request->data . '%' )->paginate( 36 );

        return view( 'pages.product', compact( 'product' ) );

    }

}