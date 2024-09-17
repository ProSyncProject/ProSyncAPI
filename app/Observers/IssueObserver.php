<?php

namespace App\Observers;

use App\Models\Issue;

class IssueObserver
{
    /**
     * Handle the Issue "created" event.
     */
    public function created(Issue $issue): void
    {
        $project = $issue->project;
        $last_identifier = $project->identifiers()->latest()->first();

        $issue->identifier()->create([
            'project_id' => $project->id,
            'issue_number' => $last_identifier ? $last_identifier->issue_number + 1 : 1,
        ]);
    }
}
