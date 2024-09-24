<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\IssueStatus;
use App\Models\SubIssue;

final readonly class UpdateSubIssueStatus
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $issueUniqueId = array_key_exists('subIssueUniqueId', $args) ? $args['subIssueUniqueId'] : null;
        $statusId = array_key_exists('statusId', $args) ? $args['statusId'] : null;

        $issue = SubIssue::where('unique_id', $issueUniqueId)->first();
        $status = IssueStatus::where('unique_id', $statusId)->first();

        if ($issue) {
            $issue->status_id = $status->id;
            $issue->save();
            return $issue;
        }
    }
}
