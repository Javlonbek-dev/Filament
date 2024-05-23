<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use PHPUnit\Framework\Attributes\Ticket;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendee>
 */
class AttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name,
            'email'=>$this->faker->safeEmail,
            'ticket_cost'=>5000,
            'is_paid'=>true,
            'order_id'=>Order::factory(),
            'created_at'=>$this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
