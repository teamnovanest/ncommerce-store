<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $baseTotal = $this->faker->randomNumber(5, false);
        return [
            "user_id" => \App\Models\User::all()->random()->id,
            "merchant_organization_id" => \App\Models\Merchant::all()->random()->id,
            "status_id" => \App\Models\StatusOptions::all()->random()->id,
            "order_code" => $this->faker->ean13(),
            "subtotal" =>  $baseTotal,
            "total" =>  $baseTotal + 10,
            "status" =>  0,
            "return_order" =>  null,
            "month" =>  $this->faker->date('m'),
            "date" =>  $this->faker->date('Y-m-d'),
            "year" =>  $this->faker->date('Y'),
            "status_code" =>  null,
            "reason_for_rejection" =>  null
        ];
    }
}
