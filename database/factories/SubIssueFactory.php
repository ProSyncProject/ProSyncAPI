<?php

namespace Database\Factories;

use App\Models\Epic;
use App\Models\IssueStatus;
use App\Models\IssueType;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubIssue>
 */
class SubIssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $project = \App\Models\Project::with('issueTypes', 'issueStatuses', 'priorities', 'users', 'epics')->get()->random();
        $status = $project->issueStatuses->count() ? $project->issueStatuses->random() : IssueStatus::factory()->create(['project_id' => $project->id]);
        $priority = $project->priorities->count() ? $project->priorities->random() : Priority::factory()->create(['project_id' => $project->id]);
        $assignee = $project->users->count() ? $project->users->random() : User::factory()->create();
        $reporter = $project->users->count() ? $project->users->random() : User::factory()->create();

        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'issue_id' => $project->id,
            'status_id' => $status->id,
            'priority_id' => $priority->id,
            'assignee_id' => $assignee->id,
            'reporter_id' => $reporter->id,
            'due_date' => $this->faker->dateTime,
        ];
    }
}
