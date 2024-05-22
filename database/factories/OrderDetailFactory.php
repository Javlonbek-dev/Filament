<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\OrderDetailLength;
use App\OrderDetailStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name(),
            'start_date'=>$this->faker->dateTime(),
            'end_date'=>$this->faker->dateTime(),
            'length'=>$this->faker->randomElement(OrderDetailLength::class),
            'status'=>$this->faker->randomElement(OrderDetailStatus::class),
            'ordered'=>$this->faker->boolean(),
            'info'=>$this->faker->text(60),
            'supplier_id'=>Supplier::factory(),

        ];
    }
}
