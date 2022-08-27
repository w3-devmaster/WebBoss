<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxIdIntoSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'settings', function ( Blueprint $table )
        {
            $table->string( 'tax_id', 13 )->nullable()->after( 'company_name' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'settings', function ( Blueprint $table )
        {
            $table->dropColumn( 'tax_id' );
        } );
    }
}