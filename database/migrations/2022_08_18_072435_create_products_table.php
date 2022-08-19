<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'products', function ( Blueprint $table )
        {
            $table->id();
            $table->string( 'code', 10 )->unique();
            $table->string( 'product_name' );
            $table->longText( 'product_details' );
            $table->string( 'color' )->nullable();
            $table->integer( 'category' );
            $table->bigInteger( 'amount' )->default( 0 );
            $table->float( 'price', 11, 2 )->default( 0 );
            $table->tinyInteger( 'discount' )->dafault( 0 );
            $table->float( 'dis_price', 11, 2 )->default( 0 );
            $table->integer( 'remain' )->default( 0 );
            $table->bigInteger( 'view' )->default( 0 );
            $table->bigInteger( 'buy' )->default( 0 );
            $table->string( 'image' );
            $table->json( 'images' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'products' );
    }
}