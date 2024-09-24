<?php

namespace Database\Seeders;

use AchyutN\LaravelComment\Models\Comment;
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
        Project::factory()
            ->hasAttached(User::find(1), ['role' => 'owner'])
            ->hasAttached(User::factory()->count(5), ['role' => 'member'])
            ->hasEpics(2)
            ->has(
                Sprint::factory()->count(1)
                    ->has(Issue::factory()->count(15)
                        ->has(SubIssue::factory()->count(3))
                    )
            )
            ->create();
    }
}
