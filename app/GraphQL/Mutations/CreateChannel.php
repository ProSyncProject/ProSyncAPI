<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

final readonly class CreateChannel
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        dd($args);
    }
}
