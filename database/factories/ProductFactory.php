<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'            => genProductCode(),
            'product_name'    => $this->faker->name(),
            'product_details' => $this->faker->text( 500 ),
            'color'           => $this->faker->colorName(),
            'category'        => Category::all()->random( 1 )->first()->id,
            'amount'          => $this->faker->numberBetween( 0, 100 ),
            'price'           => $this->faker->numberBetween( 10, 100 ),
            'discount'        => $this->faker->numberBetween( 0, 2 ),
            'dis_price'       => $this->faker->numberBetween( 0.00, 15.00 ),
            'remain'          => $this->faker->numberBetween( 0, 15 ),
            'image'           => 'public/default-images/stationery.png',
            'images'          => json_encode( json_decode( '["public\/default-images\/stationery.png","public\/default-images\/stationery.png","public\/default-images\/stationery.png","public\/default-images\/stationery.png","public\/default-images\/stationery.png","public\/default-images\/stationery.png"]', true ) ),
        ];
    }
}