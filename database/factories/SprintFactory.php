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
        $project = \App\Models\Project::get()->random();
        $sprints = $project->sprints;
        return [
            'name' => "Sprint " . ($sprints->count() + 1),
            'goal' => $this->faker->words(6, true),
            'description' => $this->faker->paragraph,
            'project_id' => $project->id,
            'start_date' => $this->faker->dateTimeBetween('-2 months', '+2 months'),
            'end_date' => $this->faker->dateTimeBetween('+3 months', '+5 months'),
            'completed_at' => $this->faker->randomElement([null, $this->faker->dateTime]),
        ];
    }
}
