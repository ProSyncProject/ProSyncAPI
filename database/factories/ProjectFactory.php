<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefix = '';
        for ($i = 0; $i < $this->faker->randomElement([2,3]); $i++) {
            $prefix .= $this->faker->randomLetter;
        }
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'prefix' => strtoupper($prefix),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'parent_id' => $this->faker->randomElement([null, \App\Models\Project::factory(), \App\Models\Project::count() > 0 ? \App\Models\Project::get()->random()->id : null]),
            'privacy' => $this->faker->randomElement(['public', 'private']),
        ];
    }
}
