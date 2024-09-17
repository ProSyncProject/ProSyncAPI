<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueType extends Model
{
    use SoftDeletes, HasUniqueId, HasFactory;
    protected $fillable = ['name', 'icon'];

    /**
     * Get the project that owns the IssueType
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The issues associated with the issue status
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'type_id');
    }

    /**
     * The sub-issues associated with the issue status
     *
     * @return HasMany
     */
    public function subIssues(): HasMany
    {
        return $this->hasMany(SubIssue::class, 'type_id');
    }
}
