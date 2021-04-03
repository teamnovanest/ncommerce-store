<?php

namespace Database\Factories;

use App\Models\CustomerFinanceOrganizationAffiliation;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFinanceOrganizationAffiliationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerFinanceOrganizationAffiliation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" =>  \App\Models\User::all()->random()->id,
            "user_external_reference_id" => $this->faker->ean13(),
            "lender_organization_id" =>  \App\Models\Lender::all()->random()->id
        ];
    }
}
