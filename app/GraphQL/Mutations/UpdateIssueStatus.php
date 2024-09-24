<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Issue;
use App\Models\IssueStatus;

final readonly class UpdateIssueStatus
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $issueUniqueId = array_key_exists('issueUniqueId', $args) ? $args['issueUniqueId'] : null;
        $statusId = array_key_exists('statusId', $args) ? $args['statusId'] : null;

        $issue = Issue::where('unique_id', $issueUniqueId)->first();
        $status = IssueStatus::where('unique_id', $statusId)->first();

        if ($issue) {
            $issue->status_id = $status->id;
            $issue->save();
            return $issue;
        }
    }
}
