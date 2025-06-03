<?php

namespace Database\Seeders;

use App\Models\BookingRequests;
use Database\Factories\BookingRequestsFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookingRequests::factory()
                    ->count(1)
                    ->create();
    }
}
