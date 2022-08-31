<?php

use App\Models\Billing;
use App\Models\Category;
use App\Models\Product;
use App\Models\Receipt;

if ( !function_exists( 'getCategoryChildByParent' ) )
{
    function getCategoryChildByParent( $parent )
    {
        if ( !Category::whereParent( $parent )->exists() )
        {
            return false;
        }

        $data = [];
        $cats = Category::whereParent( $parent )->get();

        foreach ( $cats as $key => $value )
        {
            $data[] = [
                "id"         => $value->id,
                "name"       => $value->name,
                "img"        => $value->img,
                "level"      => $value->level,
                "parent"     => $value->parent,
                "created_at" => $value->created_at,
                "updated_at" => $value->updated_at,
                'child'      => Category::whereParent( $value->id )->exists(),
            ];
        }

        return $data;
    }
}

if ( !function_exists( 'getParentForSelect' ) )
{
    function getParentForSelect( $id )
    {
        if ( $id == null )
        {
            return 'หมวดหมู่หลัก';
        }

        if ( $id == 0 )
        {
            return '-';
        }

        $name = '';

        $item = [];

        $category = Category::find( $id );
        $item[]   = $category->name;

        if ( $category->parent > 0 )
        {
            $category = Category::find( $category->parent );
            $item[]   = $category->name;
            if ( $category->parent > 0 )
            {
                $category = Category::find( $category->parent );
                $item[]   = $category->name;
                if ( $category->parent > 0 )
                {
                    $category = Category::find( $category->parent );
                    $item[]   = $category->name;
                }
            }
        }

        for ( $i = count( $item ); $i > 0; $i-- )
        {
            $name .= $item[$i - 1];
            if ( $i > 1 )
            {
                $name .= ' >> ';
            }
        }

        return $name;
    }
}

if ( !function_exists( 'getParentSeqments' ) )
{
    function getParentSeqments( $id = null )
    {
        if ( $id === null || $id === 0 )
        {
            return [];
        }

        $item = [];

        $category            = Category::find( $id );
        $item[$category->id] = $category->name;

        if ( $category->parent > 0 )
        {
            $category            = Category::find( $category->parent );
            $item[$category->id] = $category->name;
            if ( $category->parent > 0 )
            {
                $category            = Category::find( $category->parent );
                $item[$category->id] = $category->name;
                if ( $category->parent > 0 )
                {
                    $category            = Category::find( $category->parent );
                    $item[$category->id] = $category->name;
                }
            }
        }

        $item = array_flip( $item );
        $item = array_reverse( $item );
        $item = array_flip( $item );

        return $item;
    }
}

if ( !function_exists( 'getProduct' ) )
{
    function getProduct( $id )
    {
        if ( !Product::whereId( $id )->exists() )
        {
            return null;
        }

        return Product::find( $id );
    }
}

if ( !function_exists( 'countProductByCat' ) )
{
    function countProductByCat( $category )
    {
        return Product::where( 'category', $category )->count();
    }
}

if ( !function_exists( 'getReceiptFromPo' ) )
{
    function getReceiptFromPo( $po )
    {
        if ( !Receipt::whereBilling( $po->id )->exists() )
        {
            return Receipt::create( [
                'user'         => $po->user,
                'code'         => genReceiptCode( $po->mode ),
                'billing'      => $po->id,
                'mode'         => $po->mode,
                'tax_id'       => $po->tax_id,
                'customer'     => $po->customer,
                'send_address' => $po->send_address,
                'product'      => $po->product,
            ] );
        }
        else
        {
            return Receipt::whereBilling( $po->id )->first();
        }
    }
}

if ( !function_exists( 'getBilling' ) )
{
    function getBilling( $id )
    {
        return Billing::whereId( $id )->first();
    }
}

?>