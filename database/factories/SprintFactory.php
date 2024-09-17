<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sprint>
 */
class SprintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'goal' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'project_id' => \App\Models\Project::get()->random()->id,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'completed_at' => $this->faker->randomElement([null, $this->faker->dateTime]),
        ];
    }
}
