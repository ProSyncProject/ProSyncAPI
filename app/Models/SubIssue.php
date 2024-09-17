<?php

namespace App\Models;

use AchyutN\LaravelComment\Traits\HasComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubIssue extends Model
{
    use SoftDeletes, HasComment;

    protected $fillable = [
        'unique_id',
        'issue_id',
        'issue_number',
        'name',
        'description',
        'issue_type_id',
        'issue_status_id',
        'priority_id',
        'epic_id',
        'assignee_id',
        'reporter_id',
        'due_date',
    ];

    /**
     * Get the issue that owns the SubIssue
     *
     * @return BelongsTo
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    /**
     * Get the issueStatus that owns the SubIssue
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(IssueStatus::class, 'status_id');
    }

    /**
     * Get the priority that owns the SubIssue
     *
     * @return BelongsTo
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    /**
     * Get the user that owns the SubIssue
     *
     * @return BelongsTo
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Get the user that owns the SubIssue
     *
     * @return BelongsTo
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the identifier for the sub-issue.
     *
     * @return MorphOne
     */
    public function identifier(): MorphOne
    {
        return $this->morphOne(Identifier::class, 'identifiable');
    }
}
