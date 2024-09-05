<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property {{ model }} $resource
 */

class ProjectResource extends JsonResource
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
             * @var string $unique_id The unique identifier of the resource
             * @example "8aSuRX7YmXEwnLgBKNp6s"
             */
            "unique_id" => $this->unique_id,
        ];
    }
}
