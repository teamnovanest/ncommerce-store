<?php

namespace Database\Factories;

use App\Models\Sitesetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitesettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sitesetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "phone_one" => $this->faker->phoneNumber(),    
            "phone_two" => $this->faker->phoneNumber(),    
            "email" => $this->faker->email(),    
            "company_name" => "NOVANEST",    
            "company_address" => "Awoshie, Accra",    
            "facebook" => "@foobook",    
            "youtube" => "@youtube",    
            "instagram" => "@instagram",    
            "twitter" => "@twitter",    
        ];
    }
}
