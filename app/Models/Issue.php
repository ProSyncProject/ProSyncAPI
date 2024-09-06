<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unique_id',
        'issue_number',
        'name',
        'description',
        'project_id',
        'issue_type_id',
        'issue_status_id',
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
}
