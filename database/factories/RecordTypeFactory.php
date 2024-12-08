<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\RecordType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecordTypeFactory extends Factory
{

    protected $model = RecordType::class;

    public function definition(): array
    {

        return [
            'name'       => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => fn() => User::factory()->create()->id,
        ];
    }

}
