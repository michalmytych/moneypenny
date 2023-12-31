<?php

namespace Database\Factories\Synchronization;

use App\Moneypenny\Synchronization\Models\Synchronization;
use App\Moneypenny\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SynchronizationFactory extends Factory
{
    public function definition(): array
    {
        $codeStatusMap = [
            Synchronization::SYNC_STATUS_RUNNING => null,
            Synchronization::SYNC_STATUS_SUCCEEDED => 200,
            Synchronization::SYNC_STATUS_FAILED => 400,
        ];

        $randomCodeStatusKey = $this->faker->randomKey($codeStatusMap);

        return [
            'code' => $codeStatusMap[$randomCodeStatusKey],
            'status' => $randomCodeStatusKey,
            'user_id' => User::factory()->firstOrCreate()->id
        ];
    }
}
