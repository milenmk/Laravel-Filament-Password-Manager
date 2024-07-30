<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin User
        User::factory(1)->create();
        $user = User::first();

        $user->forceFill(
            [
                'name' => 'Milen Karaganski',
                'email' => 'milenmk@gmail.com',
            ],
        )->save();

        // Create some more users
        User::factory(20)->create();
    }
}
