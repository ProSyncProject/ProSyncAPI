<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;

final readonly class UpdateUser
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
//        unique_id: String!
//    first_name: String
//        middle_name: String
//        last_name: String
//        username: String
//        email: String

        $uniqueId = array_key_exists('unique_id', $args) ? $args['unique_id'] : null;
        $firstName = array_key_exists('first_name', $args) ? $args['first_name'] : null;
        $middleName = array_key_exists('middle_name', $args) ? $args['middle_name'] : null;
        $lastName = array_key_exists('last_name', $args) ? $args['last_name'] : null;
        $username = array_key_exists('username', $args) ? $args['username'] : null;
        $email = array_key_exists('email', $args) ? $args['email'] : null;

        $user = User::where('unique_id', $uniqueId)->first();
        if (!$user) {
            throw new \Exception("User not found.");
        }

        $user->update([
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
        ]);

        return $user;
    }
}
