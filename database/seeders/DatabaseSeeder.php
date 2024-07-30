<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some users
        $this->call([UserSeeder::class]);

        // Create some domains
        foreach (User::all() as $user) {
            Domain::factory(10)->create(['user_id' => $user->id]);
        }
    }
}
