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
        return [
            'unique_id' => $this->faker->unique()->uuid,
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'prefix' => $this->faker->word,
            'owner_id' => $this->faker->randomElement([User::factory(), User::get()->random()->id]),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'parent_id' => $this->faker->randomElement([null, \App\Models\Project::factory(), \App\Models\Project::get()->random()->id]),
            'privacy' => $this->faker->randomElement(['public', 'private']),
        ];
    }
}
