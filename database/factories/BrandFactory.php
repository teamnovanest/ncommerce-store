<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "brand_id" => \App\Models\BrandOptions::all()->random()->id,
            "merchant_organization_id" =>  \App\Models\Merchant::all()->random()->id,
            "logo_public_id" => $this->faker->word(),
            "logo_secure_url" =>  "https://loremflickr.com/320/240"

        ];
    }
}
