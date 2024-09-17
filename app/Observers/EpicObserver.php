<?php

namespace App\Observers;

use App\Models\Epic;

class EpicObserver
{
    /**
     * Handle the Epic "created" event.
     */
    public function created(Epic $epic): void
    {
        $project = $epic->project;
        $last_identifier = $project->identifiers()->orderBy('issue_number', 'desc')->first();

        $epic->identifier()->create([
            'project_id' => $project->id,
            'issue_number' => $last_identifier ? $last_identifier->issue_number + 1 : 1,
        ]);
    }
}
