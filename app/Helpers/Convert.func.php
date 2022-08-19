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
            return $discount[$dis];
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

?>