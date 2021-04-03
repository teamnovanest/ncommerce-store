<?php

namespace Database\Factories;

use App\Models\BrandOptions;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandOptionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BrandOptions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "brand_name" => $this->faker->word()
        ];
    }
}
