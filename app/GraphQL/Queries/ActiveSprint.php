<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;

final readonly class ActiveSprint
{
    /** @param array{} $args */
    public function __invoke(null $_, array $args)
    {
        $project = array_key_exists('project', $args) ? $args['project'] : null;
        return Project::with('sprints.issues.project')->where('prefix', $project)->first()->activeSprint()
            ->whereHas('issues', function ($query) use ($project) {
                $query->whereHas('project', function ($query) use ($project) {
                    $query->where('prefix', $project);
                })
                ->orderBy('status_id', 'asc');
            })->first();
    }
}
