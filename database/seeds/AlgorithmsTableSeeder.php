<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlgorithmsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('algorithms')->insert([
            'name' => 'Test Algoritm',
            'description' => 'Test Description',
            'parameter' => 'Test Parameter',
            'reference' => 'Test Reference',
            'parent_id' => 1
        ]);
    }
}
