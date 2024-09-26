<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Project;

final readonly class GetProjectByUniqueId
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $uniqueId = array_key_exists('unique_id', $args) ? $args['unique_id'] : null;

        return Project::where('unique_id', $uniqueId)->first();
    }
}
