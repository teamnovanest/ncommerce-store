<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubcategoryOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SubcategoryOptions::factory->create();
    }
}
