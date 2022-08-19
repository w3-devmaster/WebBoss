<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create( [
            'firstname' => 'Administrator',
            'lastname'  => 'Master',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make( '123456' ),
            'type'      => 100,
        ] );
    }
}