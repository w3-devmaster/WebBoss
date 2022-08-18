<?php

use App\Models\Category;

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
        if ( $id == null )
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

?>