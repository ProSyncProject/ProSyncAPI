<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Channel;
use App\Models\User;

final readonly class CreateChannel
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $channelName = array_key_exists('name', $args) ? $args['name'] : null;
        $userUniqueIds = array_key_exists('users', $args) ? $args['users'] : null;

        $userUniqueIds = array_merge($userUniqueIds, [auth()->user()->unique_id]);
        $users = User::whereIn('unique_id', $userUniqueIds)->get();

        if ($channelName == "") {
            $channel = Channel::whereHas('users', function ($query) use ($users) {
                $query->whereIn('users.id', $users->pluck('id'));
            }, '=', $users->count())->first();

            if ($channel) {
                return $channel;
            }
        }

        $channel = Channel::create([
            'name' => $channelName,
        ]);

        $channel->users()->attach($users);

        return $channel;
    }
}
