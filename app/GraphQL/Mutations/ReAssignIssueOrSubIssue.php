<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Issue;
use App\Models\Notification;
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

        $issueSubIssue = $query->where('unique_id', $uniqueId)->first();

        $issueSubIssue->update(['assignee_id' => $user->id]);

        $theType = $type === 'issue' ? 'issue' : 'sub-issue';

        if($user->id !== auth()->id()) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'You have been assigned to ' . $theType . ' ' . $issueSubIssue->issue_number,
            ]);
        }

        return $user;
    }
}
