<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

final readonly class MarkAllNotificationsAsRead
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $notifications = auth()->user()->notifications()->whereNull('read_at')->get();
        $notifications->each->markAsRead();
        return auth()->user();
    }
}
