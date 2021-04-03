<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\StatusOptions::factory->create();
    }
}
