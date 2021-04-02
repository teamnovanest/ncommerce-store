<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Lender::factory->create();
    }
}
