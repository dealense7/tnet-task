<?php

namespace Database\Factories;

use App\Enums\PlayerPosition;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    public function definition(): array
    {
        $types = [
            PlayerPosition::GOALKEEPER->value,
            PlayerPosition::DEFENDER->value,
            PlayerPosition::MIDFIELDER->value,
            PlayerPosition::ATTACKER->value,
        ];

        return [
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'age'          => rand(18, 40),
            'country_id'   => (new Country())->inRandomOrder()?->first()?->getId(),
            'market_value' => rand(1000000, 3000000) * 100,
            'type'         => $this->faker->randomElement($types)
        ];
    }
}
