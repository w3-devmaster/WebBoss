<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountIntoBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'billings', function ( Blueprint $table )
        {
            $table->tinyInteger( 'discount' )->default( 0 )->after( 'order_status' );
            $table->float( 'dis_price' )->default( 0 )->after( 'discount' );

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'billings', function ( Blueprint $table )
        {
            $table->dropColumn( ['discount', 'dis_price'] );
        } );
    }
}