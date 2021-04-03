<?php

namespace Database\Factories;

use App\Models\Lender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LenderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lender::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = $this->faker->company();

        return [
            "registered_name" =>  $company,
            "trade_name" =>  Str::upper($company)
        ];
    }
}
