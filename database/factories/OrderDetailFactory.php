<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $baseTotal = $this->faker->randomNumber(5, false);
        return [
            "order_id" => \App\Models\Order::all()->random()->id,
            "product_id" => \App\Models\Product::all()->random()->id,
            "merchant_organization_id" => \App\Models\Merchant::all()->random()->id,
            "product_name" => null,
            "color" => null,
            "size" => null,
            "quantity" => $this->faker->randomNumber(3, false),
            "singleprice" => $baseTotal,
            "singleprice" => $baseTotal + 10,
        ];
    }
}
