<?php

namespace Database\Factories;

use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Supplier;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $qualificationsCount = $this->faker->numberBetween(0, 10);
        $qualifications = $this->faker->randomElement([array_keys(Supplier::QUALIFICATIONS),$qualificationsCount]);
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'current_locate' => $this->faker->word(),
            'qualifications'=>$qualifications
        ];
    }

    public function withOrderDetails(int $count=1):self
    {
        return $this->has(OrderDetail::factory()->count($count), 'order_details');
    }
}

