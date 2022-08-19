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
            'image'           => 'public/product/00001/b12f1ee5b52a21b2d57d55b54ad33908-162009.jpg',
            'images'          => json_encode( json_decode( '["public\/product\/00001\/9f033bf903b5ce89642302ef9923b8be-2.png","public\/product\/00001\/0354285e00be770683d66d5d57842234-3.png","public\/product\/00001\/867d1453537921db736e4126d54e941e-4.png","public\/product\/00001\/42ccf51c043ce1a3474cf00e889d5a68-5.png","public\/product\/00001\/a292bb05ae02394914d70f499c15936e-6.png","public\/product\/00001\/ddc654135d53bd21bf47651d34b1d897-7.png"]', true ) ),
        ];
    }
}