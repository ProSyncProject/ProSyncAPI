<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;
use App\Models\User;

final readonly class FilterUsers
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $project = array_key_exists('project', $args) ? $args['project'] : null;
        if (!$project) {
            return User::query()->latest()->get();
        }
        $query = Project::with('users')->where('prefix', $project)->first()->users();
        return $query->latest()->get();
    }
}
