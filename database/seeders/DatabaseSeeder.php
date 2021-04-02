<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          \App\Models\User::factory(10)->create();
          \App\Models\BrandOptions::factory(10)->create();
          \App\Models\Merchant::factory(4)->create();
          \App\Models\Brand::factory(10)->create();
          \App\Models\Category::factory(6)->create();
          \App\Models\Subcategory::factory(6)->create();
          \App\Models\Lender::factory(4)->create();
          \App\Models\CustomerFinanceOrganizationAffiliation::factory(20)->create();
          \App\Models\Product::factory(1000)->create();
    }
}
