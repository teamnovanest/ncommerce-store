<?php

namespace Database\Factories;

use App\Models\OrderFinancing;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFinancingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderFinancing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => \App\Models\User::all()->random()->id,
            "lender_organization_id" => \App\Models\Lender::all()->random()->id,
            "payment_period" => \App\Models\LenderOffering::all()->random()->payment_period,
            "percentage" => \App\Models\LenderOffering::all()->random()->percentage,
        ];
    }
}
