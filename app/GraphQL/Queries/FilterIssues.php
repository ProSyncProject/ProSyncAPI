<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

final readonly class FilterIssues
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $filter = array_key_exists('filter', $args) ? $args['filter'] : null;
        $query = auth()->user()->assignedAndCreatedIssues();
        switch ($filter) {
            case 'latest':
                return $query->latest()->get();
            case 'completed':
                return $query->completed()->latest()->get();
            case 'inProgress':
                return $query->notCompleted()->latest()->get();
            default:
                return auth()->user()->issues()->get();
        }
    }
}
