<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $userType = [null,'MANAGER', "SUPER_ADMIN", "MERCHANT_EMPLOYEE", "LENDER_EMPLOYEE"];
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'profile_photo_path' => "https://placeimg.com/100/100/people",
            'user_type' => $this->faker->randomElement($userType),
            'merchant_organization_id' => $this->faker->randomElement([null,1,2,3,4,5]),
            'lender_organization_id' => $this->faker->randomElement([null,1,2,3]),
            'password' => '$2y$10$zj2ZKaBnQO8Ns4AQG9wE2uw28mXw/19FZZjwfapx3U6wl06UaZeY2', // 12345678
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
