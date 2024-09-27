<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;

final readonly class AuthorizeGithub
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {

        $input = array_key_exists('inputs', $args) ? $args['inputs'] : null;

        $firebase_id = array_key_exists('firebase_id', $input) ? $input['firebase_id'] : null;
        $github_id = array_key_exists('github_id', $input) ? $input['github_id'] : null;
        $github_token = array_key_exists('github_token', $input) ? $input['github_token'] : null;
        $github_refresh_token = array_key_exists('github_refresh_token', $input) ? $input['github_refresh_token'] : null;
        $github_username = array_key_exists('github_username', $input) ? $input['github_username'] : null;

        $user = auth()->user();

        if (!$user) {
            throw new \Exception("User not found.");
        }

        if ($user->firebase_id !== null) {
            throw new \Exception("User already authorized with Firebase.");
        }

        $user->update([
            'firebase_id' => $firebase_id,
            'github_id' => $github_id,
            'github_token' => $github_token,
            'github_refresh_token' => $github_refresh_token,
            'github_username' => $github_username,
        ]);

        return $user;
    }
}
