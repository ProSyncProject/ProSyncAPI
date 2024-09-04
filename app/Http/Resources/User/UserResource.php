<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Vendor\VendorCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var int $id
             * @example 1
             */
            'id' => $this->id,
            /**
             * The login token
             * @var string|null $token The login token
             * @example null
             */
            'token' => $this->whenNotNull($this->token),
            /**
             * @var string $first_name The first_name of the user
             * @example "User"
             */
            'first_name' => $this->first_name,
            /**
             * @var string $middle_name The middle_name of the user
             * @example "First"
             */
            'middle_name' => $this->middle_name,
            /**
             * @var string $last_name The last_name of the user
             * @example "Name"
             */
            'last_name' => $this->last_name,
            /**
             * @var string $full_name The full_name of the user
             * @example "User First Name"
             */
            'full_name' => $this->full_name,
            /**
             * @var string $email The email of the user
             * @format email
             * @example "achyutkneupane@gmail.com"
             */
            'email' => $this->email,
            /**
             * @var string $username The username of the user
             * @example "achyut"
             */
            'username' => $this->username,
            /**
             * @var string $unique_id The unique identifier of the user
             * @example "8aSuRX7YmXEwnLgBKNp6s"
             */
            "unique_id" => $this->unique_id,
            /**
             * @var string $email_verified_at The email_verified_at of the user
             * @format date-time
             * @example "2021-05-31T06:00:00.000000Z"
             */
            'email_verified_at' => $this->email_verified_at,
            /**
             * @var string $remember_token The remember_token of the user
             * @example "remember_token"
             */
            'remember_token' => $this->remember_token,
            /**
             * @var string $deleted_at The deleted_at of the user
             * @format date-time
             * @example "2021-05-31T06:00:00.000000Z"
             */
            'deleted_at' => $this->deleted_at,
            /**
             * @var string $created_at The created_at of the user
             * @format date-time
             * @example "2021-05-31T06:00:00.000000Z"
             */
            'created_at' => $this->created_at,
            /**
             * @var string $updated_at The updated_at of the user
             * @format date-time
             * @example "2021-05-31T06:00:00.000000Z"
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
