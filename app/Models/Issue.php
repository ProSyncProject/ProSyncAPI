<?php

namespace App\Models;

use AchyutN\LaravelComment\Traits\HasComment;
use App\Observers\IssueObserver;
use App\Traits\HasIdentifier;
use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([IssueObserver::class])]
class Issue extends Model
{
    use SoftDeletes, HasComment, HasUniqueId, HasFactory, HasIdentifier;

    protected $fillable = [
        'unique_id',
        'issue_number',
        'name',
        'description',
        'project_id',
        'type_id',
        'status_id',
        'priority_id',
        'epic_id',
        'assignee_id',
        'reporter_id',
        'due_date',
    ];

    /**
     * Get the project that owns the Issue
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the issueType that owns the Issue
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(IssueType::class, 'type_id');
    }

    /**
     * Get the issueStatus that owns the Issue
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(IssueStatus::class, 'status_id');
    }

    /**
     * Get the priority that owns the Issue
     *
     * @return BelongsTo
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * Get the epic that owns the Issue
     *
     * @return BelongsTo
     */
    public function epic(): BelongsTo
    {
        return $this->belongsTo(Epic::class);
    }

    /**
     * Get the assignee that owns the Issue
     *
     * @return BelongsTo
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get the reporter that owns the Issue
     *
     * @return BelongsTo
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the sprints for the issue.
     *
     * @return BelongsToMany
     */
    public function sprints(): BelongsToMany
    {
        return $this->belongsToMany(Sprint::class)
            ->using(IssueSprint::class)
            ->withTimestamps();
    }

    /**
     * Get active sprint for the issue.
     *
     * @return Sprint
     */
    public function activeSprint(): Sprint
    {
        return $this->sprints()->orderBy('start_date', 'desc')->first();
    }

    /**
     * Get the subIssues for the issue.
     *
     * @return HasMany
     */
    public function subIssues(): HasMany
    {
        return $this->hasMany(SubIssue::class);
    }
}
