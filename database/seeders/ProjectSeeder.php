<?php

namespace Database\Seeders;

use AchyutN\LaravelComment\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Sprint;
use App\Models\SubIssue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->count(10)
            ->hasEpics(2)->has(
                Sprint::factory()->count(3)
                    ->has(Issue::factory()->count(5)
                        ->has(SubIssue::factory()->count(3))
                    )
            )->create();
    }
}
