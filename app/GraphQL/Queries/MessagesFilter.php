<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Channel;

final readonly class MessagesFilter
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $channelId = array_key_exists('channel', $args) ? $args['channel'] : null;
        $channel = Channel::where('unique_id', $channelId)->first();

        if (!$channel) {
            throw new \Exception('Channel not found');
        }

        return $channel->messages()->orderBy('created_at', 'desc')->get();
    }
}
