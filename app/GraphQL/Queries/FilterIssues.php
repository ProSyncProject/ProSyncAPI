<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;

final readonly class FilterIssues
{
    /** @param array{} $args */
    public function __invoke(null $_, array $args)
    {
        $filter = array_key_exists('filter', $args) ? $args['filter'] : null;
        $project = array_key_exists('project', $args) ? $args['project'] : null;
        $query = auth()->user()->createdIssues()->union(auth()->user()->issues());
        switch ($filter) {
            case 'latest':
                return $query->latest()->get();
            case 'completed':
                return $query->completed()->latest()->get();
            case 'in-progress':
                return $query->notCompleted()->latest()->get();
            case 'assigned':
                return auth()->user()->issues()->latest()->get();
            default:
                return $project ? Project::with('issues')->where('prefix', $project)->first()->issues->sortByDesc('id') : [];
        }
    }
}
