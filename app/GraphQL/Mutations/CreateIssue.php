<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Issue;
use App\Models\Project;

class CreateIssue
{
    /**
     * @param mixed $root
     * @param array $args
     * @return Issue
     */
    public function __invoke(mixed $root, array $args): Issue
    {
        $project = Project::where('prefix', $args['projectPrefix'])->first();
        return $project->issues()->create(['name' => $args['name']]);
    }
}
