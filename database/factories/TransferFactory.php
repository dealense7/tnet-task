<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'price' => rand(1000000, 3000000) * 100,
        ];
    }
}
