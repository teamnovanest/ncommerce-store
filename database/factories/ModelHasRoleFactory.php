<?php

namespace Database\Factories;

use App\Models\ModelHasRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

class ModelHasRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModelHasRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "role_id" =>  Role::all()->random()->id,
            "model_type" => "App\Models\User",
            "model_id" =>  \App\Models\User::all()->random()->id,
            "updated_at" => now()
        ];
    }
}
