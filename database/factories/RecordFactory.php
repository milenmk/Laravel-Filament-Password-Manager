<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Record;
use App\Models\RecordType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecordFactory extends Factory
{
    protected $model = Record::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
            'username' => $this->faker->userName(),
            'password' => bcrypt($this->faker->password()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'record_type_id' => fn() => RecordType::factory()->create()->id,
            'domain_id' => fn() => Domain::factory()->create()->id,
        ];
    }
}
