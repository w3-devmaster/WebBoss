<?php

use App\Models\Billing;
use App\Models\Product;
use App\Models\Receipt;

if ( !function_exists( 'genProductCode' ) )
{
    function genProductCode()
    {
        if ( Product::count() > 0 )
        {
            $count = Product::orderByDesc( 'id' )->first()->id + 1;
        }
        else
        {
            $count = 1;
        }

        $prefix = '';

        for ( $i = strlen( $count ); $i < 5; $i++ )
        {
            $prefix .= '0';
        }

        $code = (String) $prefix . $count;

        if ( Product::whereCode( $code )->exists() )
        {
            $code = (String) $prefix . ( $count + 1 );
        }

        return $code;
    }
}

if ( !function_exists( 'genBillingCode' ) )
{
    function genBillingCode()
    {
        if ( Billing::count() > 0 )
        {
            $count = Billing::orderByDesc( 'id' )->first()->id + 1;
        }
        else
        {
            $count = 1;
        }

        $prefix = '';

        for ( $i = strlen( $count ); $i < 5; $i++ )
        {
            $prefix .= '0';
        }

        $code = 'PO-' . substr( date( 'Y' ) + 543, 2 ) . $prefix . $count;

        return $code;

    }
}

if ( !function_exists( 'genReceiptCode' ) )
{
    function genReceiptCode( $mode = 1 )
    {
        if ( Receipt::where( 'mode', $mode )->count() > 0 )
        {
            $bill  = Receipt::where( 'mode', $mode )->orderByDesc( 'id' )->first();
            $count = (Int) substr( $bill->code, 5 ) + 1;
        }
        else
        {
            $count = 1;
        }

        $prefix = '';

        for ( $i = strlen( $count ); $i < 5; $i++ )
        {
            $prefix .= '0';
        }

        if ( $mode == 1 )
        {
            $code = 'RE-';
        }

        if ( $mode == 2 )
        {
            $code = 'TI-';
        }

        $code .= substr( date( 'Y' ) + 543, 2 ) . $prefix . $count;

        return $code;

    }
}

?>