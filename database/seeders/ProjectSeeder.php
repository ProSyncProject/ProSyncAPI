<?php

namespace Database\Seeders;

use AchyutN\LaravelComment\Models\Comment;
use App\Models\Epic;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\SubIssue;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Project::factory()
//            ->hasAttached(User::find(1), ['role' => 'owner'])
//            ->hasAttached(User::factory()->count(5), ['role' => 'member'])
//            ->hasEpics(2)
//            ->has(
//                Sprint::factory()->count(1)
//                    ->has(Issue::factory()->count(15)
//                        ->has(SubIssue::factory()->count(3))
//                    )
//            )
//            ->create();


        $dateRange = \Carbon\CarbonPeriod::create('2022-01-01', '2024-12-31');

        $project = Project::factory([
            'name' => "Sunway Project",
            'description' => "This is Sunway Project",
            'prefix' => "SUN",
            'start_date' => $dateRange->getStartDate(),
            'end_date' => $dateRange->getEndDate(),
        ])->create();

        $project->users()->attach(User::find(1), ['role' => 'owner']);
        $project->users()->attach(User::factory(2)->create(), ['role' => 'admin']);
        $project->users()->attach(User::factory(5)->create(), ['role' => 'member']);

        $project->epics()->createMany([
            ['name' => 'Epic 1'],
            ['name' => 'Epic 2'],
            ['name' => 'Epic 3'],
            ['name' => 'Epic 4'],
        ]);

        $newStart = \Carbon\Carbon::parse($dateRange->getStartDate())->addMonths(rand(1, 3))->addDays(rand(1, 10));
        $newEnd = \Carbon\Carbon::parse($newStart)->addMonths(rand(2, 4))->addDays(rand(2, 15));

        $project->sprints()->create([
            'name' => 'Sprint 1',
            'start_date' => $newStart,
            'end_date' => $newEnd,
        ]);

        $newStart = \Carbon\Carbon::parse($newEnd)->addMonths(rand(1, 3))->addDays(rand(1, 10));
        $newEnd = \Carbon\Carbon::parse($newStart)->addMonths(rand(2, 4))->addDays(rand(2, 15));

        $project->sprints()->create([
            'name' => 'Sprint 2',
            'start_date' => $newStart,
            'end_date' => $newEnd,
        ]);

        $newStart = \Carbon\Carbon::parse($newEnd)->addMonths(rand(1, 3))->addDays(rand(1, 10));
        $newEnd = \Carbon\Carbon::parse($newStart)->addMonths(rand(2, 4))->addDays(rand(2, 15));

        $project->sprints()->create([
            'name' => 'Sprint 3',
            'start_date' => $newStart,
            'end_date' => $newEnd,
        ]);

        $newStart = \Carbon\Carbon::parse($newEnd)->addMonths(rand(1, 3))->addDays(rand(1, 10));
        $newEnd = \Carbon\Carbon::parse($newStart)->addMonths(rand(2, 4))->addDays(rand(2, 15));

        $project->sprints()->create([
            'name' => 'Sprint 4',
            'start_date' => $newStart,
            'end_date' => $newEnd,
        ]);

        $project->sprints->each(function ($sprint) use ($project) {
            $sprint->issues()->createMany(
                collect(range(8, 15))->map(function ($item) use ($project, $sprint) {
                    return [
                        'name' => 'Issue ' . $item,
                        'description' => 'Description for Issue ' . $item,
                        'assignee_id' => User::inRandomOrder()->first()->id,
                        'project_id' => $project->id,
                        'status_id' => $project->issueStatuses()->get()->random()->id,
                        'priority_id' => $project->priorities()->get()->random()->id,
                        'reporter_id' => User::inRandomOrder()->first()->id,
                        'due_date' => \Carbon\Carbon::parse($sprint->start_date)->addDays(rand(1, 100)),
                    ];
                })->toArray()
            );

            $sprint->issues->each(function ($issue) use ($sprint) {
                $issue->subIssues()->createMany(
                    collect(range(1, 3))->map(function ($item) use ($sprint, $issue) {
                        return [
                            'name' => 'Sub Issue ' . $item,
                            'description' => 'Description for Sub Issue ' . $item,
                            'assignee_id' => User::inRandomOrder()->first()->id,
                            'issue_id' => $issue->id,
                            'status_id' => $issue->project->issueStatuses()->get()->random()->id,
                            'priority_id' => $issue->project->priorities()->get()->random()->id,
                            'reporter_id' => User::inRandomOrder()->first()->id,
                            'due_date' => \Carbon\Carbon::parse($sprint->start_date)->addDays(rand(1, 100)),
                        ];
                    })->toArray()
                );
            });
        });

    }
}
