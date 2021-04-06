<?php

namespace Database\Factories;

use App\Models\LenderOffering;
use Illuminate\Database\Eloquent\Factories\Factory;

class LenderOfferingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LenderOffering::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $periods = [3, 6, 9,12,18,24,36];
        $percentages = [3, 6, 9,12,18,24,36];
        return [
            "lender_organization_id" => \App\Models\Lender::all()->random()->id, 
            "payment_period" => $this->faker->randomElement($periods), 
            "percentage" => $this->faker->randomElement($percentages), 
            "max_financed" => $this->faker->randomNumber(6, true), 
        ];
    }
}
