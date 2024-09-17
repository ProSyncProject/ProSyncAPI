<?php

namespace Database\Seeders;

use AchyutN\LaravelComment\Models\Comment;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->count(10)->create();

        $projects = Project::all();

        $projects->each(function ($project) {
            Comment::factory()->count(5)->create([
                'unique_id' => nanoId(),
                'commentable_id' => $project->id,
                'commentable_type' => Project::class,
            ]);
        });
    }
}
