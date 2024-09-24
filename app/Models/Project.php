<?php

namespace App\Models;

use AchyutN\LaravelComment\Traits\HasComment;
use App\Observers\ProjectObserver;
use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(ProjectObserver::class)]
class Project extends Model
{
    use HasFactory, SoftDeletes, HasComment, HasUniqueId;

    protected $guarded = [];

    /**
     * Get the users associated with the project
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(ProjectUser::class)->withPivot('role')->withTimestamps();
    }

    /**
     * The parent project of the project
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }

    /**
     * The children projects of the project
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Project::class, 'parent_id');
    }

    /**
     * The epics associated with the project
     *
     * @return HasMany
     */
    public function epics(): HasMany
    {
        return $this->hasMany(Epic::class);
    }

    /**
     * The priorities associated with the project
     *
     * @return HasMany
     */
    public function priorities(): HasMany
    {
        return $this->hasMany(Priority::class);
    }

    /**
     * The sprints associated with the project
     *
     * @return HasMany
     */
    public function sprints(): HasMany
    {
        return $this->hasMany(Sprint::class);
    }

    /**
     * Get active sprint for the project.
     *
     * @return HasMany|null
     */
    public function activeSprint(): HasMany|null
    {
        return $this->sprints()->orderBy('start_date', 'desc')->limit(1) ?? null;
    }

    /**
     * The issue types associated with the project
     *
     * @return HasMany
     */
    public function issueTypes(): HasMany
    {
        return $this->hasMany(IssueType::class);
    }

    /**
     * The issue statuses associated with the project
     *
     * @return HasMany
     */
    public function issueStatuses(): HasMany
    {
        return $this->hasMany(IssueStatus::class);
    }

    /**
     * The issues associated with the project
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * The sub-issues associated with the project
     *
     * @return HasManyThrough
     */
    public function subIssues(): HasManyThrough
    {
        return $this->hasManyThrough(SubIssue::class, Issue::class);
    }

    /**
     * Get the identifiers associated with the project
     *
     * @return HasMany
     */
    public function identifiers(): HasMany
    {
        return $this->hasMany(Identifier::class);
    }
}
