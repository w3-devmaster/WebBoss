<?php

if ( !function_exists( 'textFormat' ) )
{
    function textFormat( $text = '', $pattern = '', $ex = '' )
    {
        $cid     = ( $text == '' ) ? '0000000000000' : $text;
        $pattern = ( $pattern == '' ) ? '_-____-_____-__-_' : $pattern;
        $p       = explode( '-', $pattern );
        $ex      = ( $ex == '' ) ? '-' : $ex;
        $first   = 0;
        $last    = 0;
        for ( $i = 0; $i <= count( $p ) - 1; $i++ )
        {
            $first          = $first + $last;
            $last           = strlen( $p[$i] );
            $returnText[$i] = substr( $cid, $first, $last );
        }

        return implode( $ex, $returnText );
    }
}

?>