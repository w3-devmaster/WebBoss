<?php

use App\Models\Category;

if ( !function_exists( 'getDiscountMode' ) )
{
    function getDiscountMode( $dis = null )
    {
        $discount = [0 => 'ปกติ', 1 => 'ลดราคาเป็นบาท', 2 => 'ลดราคาเป็นเปอร์เซ็นต์'];
        if ( $dis === null )
        {
            return $discount;
        }
        else
        {
            return $discount[$dis] ?? '-';
        }
    }
}

if ( !function_exists( 'getCategoryName' ) )
{
    function getCategoryName( $id )
    {
        return Category::whereId( $id )->first()->name;
    }
}

if ( !function_exists( 'getBillingType' ) )
{
    function getBillingType( $t )
    {
        $type = [
            1 => 'ใบเสร็จรับเงิน',
            2 => 'ใบกำกับภาษี/ใบวางบิล',
        ];

        return $type[$t] ?? '-';
    }
}

if ( !function_exists( 'getOrderStatus' ) )
{
    function getOrderStatus( $st )
    {
        $status = [
            0 => '<span class="badge bg-dark" >รอการชำระเงิน</span>',
            1 => '<span class="badge bg-primary" >รออนุมัติการชำระเงิน</span>',
            2 => '<span class="badge bg-warning" >จัดเตรียมสินค้า</span>',
            3 => '<span class="badge bg-success" >จัดส่งแล้ว</span>',
            4 => '<span class="badge bg-secondary" >ยกเลิกคำสั่งซื้อ</span>',
            5 => '<span class="badge bg-secondary" >รอการแก้ไขการชำระเงิน</span>',
        ];

        return $status[$st] ?? '-';
    }
}

if ( !function_exists( 'getBillingStatus' ) )
{
    function getBillingStatus( $st )
    {
        $status = [
            0 => '<span class="badge bg-dark" >รอการชำระเงิน</span>',
            1 => '<span class="badge bg-primary" >รออนุมัติการชำระเงิน</span>',
            2 => '<span class="badge bg-success" >ชำระเงินแล้ว</span>',
            3 => '<span class="badge bg-danger" >ยกเลิกการชำระเงิน</span>',
        ];

        return $status[$st] ?? '-';
    }
}

if ( !function_exists( 'getAdminType' ) )
{
    function getAdminType( $type )
    {
        if ( $type >= 100 )
        {
            return '<span class="badge bg-danger" >ผู้ดูแลระบบ</span>';
        }

        return '<span class="badge bg-primary" >พนักงาน</span>';

    }
}

?>