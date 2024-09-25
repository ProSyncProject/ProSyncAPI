<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Channel;
use App\Models\Message;

final readonly class CreateMessage
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $channelUniqueId = array_key_exists('channel_id', $args) ? $args['channel_id'] : null;
        $content = array_key_exists('content', $args) ? $args['content'] : null;

        $channel = Channel::where('unique_id', $channelUniqueId)->first();

        if (!$channel) {
            throw new \Exception('Channel not found');
        }

        return Message::create([
            'content' => $content,
            'channel_id' => $channel->id,
            'user_id' => auth()->user()->id,
        ]);
    }
}
