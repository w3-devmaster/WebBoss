<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'settings', function ( Blueprint $table )
        {
            $table->id();
            $table->string( 'company_name' )->nullable();
            $table->text( 'address' )->nullable();
            $table->string( 'email' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'line' )->nullable();
            $table->string( 'facebook' )->nullable();
            $table->json( 'bank' )->nullable();
            $table->text( 'before_footer' )->nullable();
            $table->longText( 'page_howtobuy' )->nullable();
            $table->longText( 'page_howtopayment' )->nullable();
            $table->longText( 'page_about' )->nullable();
            $table->longText( 'page_contact' )->nullable();
            $table->longText( 'privacy_policy' )->nullable();
            $table->longText( 'refund_policy' )->nullable();
            $table->longText( 'product_policy' )->nullable();
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
        Schema::dropIfExists( 'settings' );
    }
}