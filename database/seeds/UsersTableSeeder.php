<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123456');
        DB::table('users')->insert([
            ['name' => 'Sefa Aras', 'email' => 'sefaaras@ktu.edu.tr', 'password' => $password], 
            ['name' => 'Hamdi Tolga Kahraman', 'email' => 'htolgakahraman@ktu.edu.tr', 'password' => $password]
        ]);
    }
}
