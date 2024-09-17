<?php

namespace App\Observers;

use App\Models\Issue;
use App\Models\SubIssue;

class SubIssueObserver
{
    /**
     * Handle the SubIssue "created" event.
     */
    public function created(SubIssue $subIssue): void
    {
        $project = $subIssue->project;
        $last_identifier = $project->identifiers()->orderBy('issue_number', 'desc')->first();

        $subIssue->identifier()->create([
            'project_id' => $project->id,
            'issue_number' => $last_identifier ? $last_identifier->issue_number + 1 : 1,
        ]);
    }
}
