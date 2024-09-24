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
        $last_identifier = $project->identifiers()->orderBy('issue_number', 'desc')->first();

        $issue->identifier()->create([
            'project_id' => $project->id,
            'issue_number' => $last_identifier ? $last_identifier->issue_number + 1 : 1,
        ]);

        $default_status = $project->issueStatuses()->where('is_default', true)->first();
        $default_priority = $project->priorities()->where('level', 1)->first();

        $issue->update([
            'status_id' => $issue->status_id ?? $default_status->id,
            'priority_id' => $issue->priority_id ?? $default_priority->id,
            'reporter_id' => $issue->reporter_id ?? auth()->id(),
        ]);
    }
}
