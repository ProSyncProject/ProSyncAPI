<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Issue;

final readonly class SubIssuesByIssue
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $issue_unique_id = array_key_exists('issue_unique_id', $args) ? $args['issue_unique_id'] : null;
        $issue = Issue::with(['subIssues' => function ($query) {
            $query->with('priority', 'status', 'assignee', 'reporter');
        }])->where('unique_id', $issue_unique_id)->first();
        return $issue ? $issue->subIssues : [];
    }
}
