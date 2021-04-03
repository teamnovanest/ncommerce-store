<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerFinanceOrganizationAffiliationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\CustomerFinanceOrganizationAffiliationSeeder::factory->has(User::factory())->create();
    }
}
