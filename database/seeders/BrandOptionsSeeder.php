<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\BrandOptions::factory->create();
    }
}
