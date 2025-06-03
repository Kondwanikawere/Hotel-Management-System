<?php

namespace Database\Factories;

use App\Models\CustomerVisits;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerVisits>
 */
class CustomerVisitsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = CustomerVisits::class;

    public function definition(): array
    {
        return [
            'roomId' => $this->faker->numberBetween(1, 100),
        ];
    }
}
