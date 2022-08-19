<?php

use App\Models\Product;

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
?>