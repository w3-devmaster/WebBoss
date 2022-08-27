<?php

use Illuminate\Support\Facades\Route;

if ( !function_exists( 'getSeqments' ) )
{
    function getSeqments( $seqment )
    {
        $seqments = [
            'admin'          => 'หน้าแรก',
            'dashboard'      => 'สรุปบัญชี',
            'changepassword' => 'เปลี่ยนรหัสผ่าน',
            'setting'        => 'ตั้งค่าระบบ',
            'bank'           => 'บัญชีธนาคาร',
            'how-to-buy'     => 'วิธีการสั่งซื้อ',
            'how-to-payment' => 'วิธีแจ้งชำระเงิน',
            'about'          => 'เกี่ยวกับเรา',
            'contact'        => 'ติดต่อเรา',
            'privacy-policy' => 'นโยบายความเป็นส่วนตัว',
            'refund-policy'  => 'นโยบายการคืนเงิน',
            'product-policy' => 'นโยบายการคืนสินค้า',
            /// Product
            'product'        => 'สินค้า',
            'category'       => 'หมวดหมู่สินค้า',
            'create'         => 'เพิ่ม',
            'user'           => 'บัญชีผู้ใช้',
            'billing'        => 'ประวัติการซื้อ',
            'billing-info'   => 'ดูบิล',
            'payment'        => 'แจ้งชำระเงิน',
            'order-list'     => 'รายการคำสั่งซื้อ',
            'order'          => 'คำสั่งซื้อ',
            'slide'          => 'ภาพสไลด์',
        ];

        return $seqments[$seqment] ?? '...';
    }
}

if ( !function_exists( 'getAdminSeqmentData' ) )
{
    function getAdminSeqmentData( $seqments )
    {
        $routes = [];

        foreach ( $seqments as $key => $seq )
        {
            $route = 'admin';
            if ( $key > 0 )
            {
                for ( $i = 1; $i <= $key; $i++ )
                {
                    if ( $i <= $key )
                    {
                        $route .= '.' . $seqments[$i];
                    }
                    else
                    {
                        $route .= $seqments[$i];
                    }
                }
                if ( !Route::has( $route ) && $key <= count( $seqments ) - 1 )
                {
                    $route .= '.index';
                }
                $routes[] = $route;
            }
            else
            {
                if ( !Route::has( $route ) )
                {
                    $route .= '.index';
                }
                $routes[] = $route;
            }
        }

        return ['seqments' => $seqments, 'routes' => $routes];
    }
}

if ( !function_exists( 'getSeqmentData' ) )
{
    function getSeqmentData( $seqments )
    {
        $routes = [];

        foreach ( $seqments as $key => $seq )
        {
            $route  = 'user';
            $params = [];
            if ( $key > 0 )
            {
                for ( $i = 1; $i <= $key; $i++ )
                {
                    if ( $i <= $key )
                    {
                        if ( !is_numeric( $seqments[$i] ) )
                        {
                            $route .= '.' . $seqments[$i];
                        }
                        else
                        {
                            $params[] = $seqments[$i];
                        }
                    }
                    else
                    {
                        $route .= $seqments[$i];
                        $params[] = [1];
                    }
                }

                if ( !Route::has( $route ) && $key <= count( $seqments ) - 1 )
                {
                    // $route .= '.index';
                }
                $routes[] = [$route, $params];
            }
            else
            {
                if ( !Route::has( $route ) )
                {
                    $route .= '.index';
                }
                $routes[] = $route;
            }
        }

        return ['seqments' => $seqments, 'routes' => $routes];
    }
}

?>
