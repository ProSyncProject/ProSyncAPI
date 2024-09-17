<?php

namespace App\Models;

use App\Observers\SprintObserver;
use App\Traits\HasIdentifier;
use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([SprintObserver::class])]
class Sprint extends Model
{
    use SoftDeletes, HasUniqueId, HasFactory, HasIdentifier;

    protected $fillable = [
        'unique_id',
        'name',
        'goal',
        'description',
        'project_id',
        'start_date',
        'end_date',
        'completed_at',
    ];

    protected array $dates = [
        'start_date',
        'end_date',
        'completed_at',
    ];

    /**
     * Get the project that owns the sprint.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the issues for the sprint.
     *
     * @return BelongsToMany
     */
    public function issues(): BelongsToMany
    {
        return $this->belongsToMany(Issue::class)
            ->using(IssueSprint::class)
            ->withTimestamps();
    }
}
