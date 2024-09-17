<?php

namespace App\Traits;

use App\Models\Identifier;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Cache;

trait HasIdentifier
{
    public function initializeHasIdentifier(): void
    {
        $this->append('issue_number');
    }

    /**
     * Get the identifier for the issue.
     *
     * @return MorphOne
     */
    public function identifier(): MorphOne
    {
        return $this->morphOne(Identifier::class, 'identifiable');
    }

    /**
     * Get the actual identifier for the issue.
     *
     * @return string
     */
    public function getIssueNumberAttribute(): string
    {
        return Cache::rememberForever('identifier-' . $this->unique_id, function () {
            return $this->identifier->project->prefix . '#' . $this->identifier->issue_number;
        });
    }
}
