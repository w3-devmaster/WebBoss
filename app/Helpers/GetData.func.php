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

?>