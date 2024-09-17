<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
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
            'description' => $this->faker->paragraph,
            'project_id' => \App\Models\Project::get()->random()->id,
            'type_id' => \App\Models\IssueType::factory(),
            'status_id' => \App\Models\IssueStatus::factory(),
            'priority_id' => \App\Models\Priority::factory(),
            'epic_id' => \App\Models\Epic::factory(),
            'assignee_id' => \App\Models\User::factory(),
            'reporter_id' => \App\Models\User::factory(),
            'due_date' => $this->faker->dateTime,
        ];
    }
}
