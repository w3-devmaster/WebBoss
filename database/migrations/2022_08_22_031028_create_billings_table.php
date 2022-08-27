<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'billings', function ( Blueprint $table )
        {
            $table->id();
            $table->bigInteger( 'user' );
            $table->string( 'code' );
            $table->tinyInteger( 'mode' );
            $table->string( 'tax_id' )->nullable();
            $table->json( 'customer' );
            $table->json( 'send_address' );
            $table->json( 'product' );
            $table->float( 'price', 11, 2 );
            $table->tinyInteger( 'bill_status' )->default( 0 );
            $table->tinyInteger( 'order_status' )->default( 0 );
            $table->string( 'sender' )->nullable();
            $table->string( 'tracking' )->nullable();
            $table->string( 'payment' )->nullable();
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
        Schema::dropIfExists( 'billings' );
    }
}