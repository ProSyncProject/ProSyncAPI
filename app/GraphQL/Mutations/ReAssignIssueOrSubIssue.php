<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Issue;
use App\Models\SubIssue;
use App\Models\User;

final readonly class ReAssignIssueOrSubIssue
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $assigneeId = array_key_exists('assignee', $args) ? $args['assignee'] : null;
        $uniqueId = array_key_exists('uniqueId', $args) ? $args['uniqueId'] : null;
        $type = array_key_exists('type', $args) ? $args['type'] : null;

        $query = match ($type) {
            'issue' => Issue::query(),
            'subIssue' => SubIssue::query(),
            default => null,
        };

        if ($query === null) {
            return null;
        }

        $user = User::where('unique_id', $assigneeId)->first();

        $query->where('unique_id', $uniqueId)->update(['assignee_id' => $user->id]);
        return $user;
    }
}
