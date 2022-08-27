<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'receipts', function ( Blueprint $table )
        {
            $table->id();
            $table->bigInteger( 'user' );
            $table->string( 'code' );
            $table->bigInteger( 'billing' );
            $table->tinyInteger( 'mode' );
            $table->string( 'tax_id' )->nullable();
            $table->json( 'customer' );
            $table->json( 'send_address' );
            $table->json( 'product' );
            $table->tinyInteger( 'cancel' )->default( 0 );
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
        Schema::dropIfExists( 'receipts' );
    }
}
