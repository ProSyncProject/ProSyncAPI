<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class IssueSprint extends Pivot
{
    /**
     * Get the issue that owns the sprint.
     *
     * @return BelongsTo
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the sprint that owns the issue.
     *
     * @return BelongsTo
     */
    public function sprint(): BelongsTo
    {
        return $this->belongsTo(Sprint::class);
    }
}
