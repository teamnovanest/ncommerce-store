<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions

        // this can be done as separate statements
        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'customer']);
        Role::create(['name' => 'merchant']);

          \App\Models\User::factory(100)->create(); 
          \App\Models\ModelHasRole::factory(10)->create(); // Using a higer number of generated  user prvents duplicate errors here
          \App\Models\BrandOptions::factory(10)->create();
          \App\Models\ProfileImage::factory(10)->create();
          \App\Models\StatusOptions::factory(5)->create();
          //\App\Models\SubcategoryOptions::factory(10)->create();
          \App\Models\Merchant::factory(4)->create();
          \App\Models\Brand::factory(10)->create();
          \App\Models\Category::factory(6)->create();
          \App\Models\Subcategory::factory(6)->create();
          \App\Models\Lender::factory(4)->create();
          \App\Models\CustomerFinanceOrganizationAffiliation::factory(20)->create();
          \App\Models\Product::factory(1000)->create();
          \App\Models\Order::factory(10)->create();
          \App\Models\OrderDetail::factory(10)->create();
          \App\Models\Sitesetting::factory(1)->create();
          //\App\Models\Wishlist::factory()->create();
    }
}
