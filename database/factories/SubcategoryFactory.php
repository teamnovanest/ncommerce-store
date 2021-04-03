<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subcategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            "category_id" =>  \App\Models\Category::all()->random()->id,
            "subcategory_name" => $this->faker->word(2, true),
            "subcategory_id" => $this->faker->randomDigit(),
            "merchant_organization_id" => \App\Models\Merchant::all()->random()->id
        ];
    }
}
