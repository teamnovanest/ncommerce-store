<?php

namespace Database\Factories;

use App\Models\StatusOptions;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusOptionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StatusOptions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ["ORDER_RECIVED", "ORDER_ACCEPTED", "FINANCING_REQUESTED", "FINANCING_APPROVED", "PAYMENT_RELEASED", "PAYMENT_RECIVED", "ORDER_FULFILED"];

        return [
            "status_name" => $this->faker->randomElement($status),
            "description" => $this->faker->text()
        ];
    }
}
