<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;

final readonly class FilterSprint
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $project = array_key_exists('project', $args) ? $args['project'] : null;
        return Project::with('sprints')->where('prefix', $project)->first()->sprints->sortByDesc('id');
    }
}
