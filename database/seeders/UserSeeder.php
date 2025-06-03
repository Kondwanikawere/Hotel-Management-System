<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\CustomerVisits;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(CustomerVisits::factory()->count(12)->state(new Sequence(
                ...collect(range(1, 12))->map(fn ($i) => ['roomId' => $i])
            )))
            ->count(15)
            ->create();
    }
}
