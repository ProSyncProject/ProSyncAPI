<?php declare(strict_types=1);

namespace App\GraphQL\Subscriptions;

use Illuminate\Http\Request;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;

final class UserLoggedIn extends GraphQLSubscription
{
    /** Check if subscriber is allowed to listen to the subscription. */
    public function authorize(Subscriber $subscriber, Request $request): bool
    {
        return true;
    }

    /** Filter which subscribers should receive the subscription. */
    public function filter(Subscriber $subscriber, mixed $root): bool
    {
        return true;
    }
}
