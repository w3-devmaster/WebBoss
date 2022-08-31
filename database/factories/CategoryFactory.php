<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if ( Category::count() == 0 )
        {
            $level = 0;
            $p     = 0;
        }
        else
        {

            $parent = Category::where( 'level', "<", 2 )->inRandomOrder()->first();

            if ( $parent->parent == 0 )
            {
                $level = 0;
            }
            else
            {
                $level = Category::find( $parent->id )->level + 1;
            }

            $p = $parent->id;
        }

        return [
            'name'   => $this->faker->name(),
            'img'    => 'public/default-images/stationery.png',
            'level'  => $level,
            'parent' => $p,
        ];
    }
}