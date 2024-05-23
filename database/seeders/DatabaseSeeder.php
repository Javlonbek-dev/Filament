<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Customer;
use App\Models\Group;
use App\Models\OrderDetail;
use App\Models\Student;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
//        Customer::factory(10)->create();
//        Student::factory(10)->create();
//        Attendee::factory(300)->create();
//        Supplier::factory(10)->create();
        OrderDetail::factory(100)->create();
//        User::factory()->create([
//            'name' => 'javlon',
//            'email' => 'test@example.com',
//        ]);

    }
}
