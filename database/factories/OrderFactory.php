<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Order;

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
     */
    public function definition(): array
    {
        $startDate=now()->addMonth(9);
        $endDate=now()->addMonth(9)->addDay(5);
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'amount' => $this->faker->numberBetween(-10000, 10000),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'region'=>$this->faker->randomElement(Region::class),
            'status'=>$this->faker->randomElement([
                'draft',
                'confirmed',
                'processing',
                'shipped',
            ]),
            'customer_id' => null,
            'supplier_id' => Supplier::factory(),
        ];
    }
}
