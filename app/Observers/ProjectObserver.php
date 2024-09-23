<?php

namespace App\Observers;

use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project->users()->attach(auth()->id(), ['role' => 'owner']);

        $statuses = ['To Do', 'In Progress', 'Completed'];

        foreach ($statuses as $status) {
            $project->statuses()->create(['name' => $status, 'is_resolved' => $status === 'Completed', 'is_default' => $status === 'To Do']);
        }

        $priorities = ['Low', 'Medium', 'High'];
        $prioritiesColor = ['#3490dc', '#f6993f', '#e3342f'];

        foreach ($priorities as $index => $priority) {
            $project->priorities()->create(['name' => $priority, 'color' => $prioritiesColor[$index], 'level' => $index + 1]);
        }
    }
}
