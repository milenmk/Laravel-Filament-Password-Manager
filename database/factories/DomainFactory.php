<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DomainFactory extends Factory
{
    protected $model = Domain::class;

    public function definition(): array
    {
        return [
            'name' => fake()->domainName(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => fn() => User::factory()->create()->id,
        ];
    }
}
