<?php

namespace Database\Factories;

use App\Models\Country;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->generateFootballTeamName($this->faker),
            'country_id' => (new Country())->inRandomOrder()?->first()?->getId() ?? Country::factory()->count(30)->create()->first()?->getId()
        ];
    }

    function generateFootballTeamName(Generator $faker): string
    {
        $prefixes = ['FC', 'United', 'Athletic', 'Real', 'City', 'Sporting', 'Olympic'];
        $suffixes = ['United', 'FC', 'Athletic', 'City', 'Rovers', 'Wanderers', 'Eagles'];

        $prefix = $faker->randomElement($prefixes);
        $suffix = $faker->randomElement($suffixes);

        if ($prefix === $suffix) {
            $suffix .= ' ' . $faker->randomElement(['Team', 'Club']);
        }

        return $prefix . ' ' . $suffix;
    }
}
