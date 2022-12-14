<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ResetStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory( 'public/category' );
        Storage::deleteDirectory( 'public/product' );
        Storage::deleteDirectory( 'public/payment' );
        Storage::deleteDirectory( 'public/slide' );
    }
}
