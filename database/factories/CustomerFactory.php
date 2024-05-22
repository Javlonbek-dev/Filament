<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'is_published' => $this->faker->boolean(),
            'region' => $this->faker->randomElement(Region::class),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
