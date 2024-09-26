<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Notification;

final readonly class MarkAsRead
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $notificationId = array_key_exists('unique_id', $args) ? $args['unique_id'] : null;

        $notification = Notification::where('unique_id', $notificationId)->first();
        $notification->markAsRead();
        return $notification;
    }
}
