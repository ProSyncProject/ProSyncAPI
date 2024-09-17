<?php

namespace App\Observers;

use App\Models\Sprint;

class SprintObserver
{
    /**
     * Handle the Sprint "created" event.
     */
    public function created(Sprint $sprint): void
    {
        $project = $sprint->project;
        $last_identifier = $project->identifiers()->latest()->first();

        $sprint->identifier()->create([
            'project_id' => $project->id,
            'issue_number' => $last_identifier ? $last_identifier->issue_number + 1 : 1,
        ]);
    }
}
