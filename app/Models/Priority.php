<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes, HasUniqueId, HasFactory;
    protected $fillable = ['name', 'level', 'color', 'icon', 'project_id'];

    /**
     * Get the project that owns the Priority
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The issues associated with the priority
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * The subIssues associated with the priority
     *
     * @return HasMany
     */
    public function subIssues(): HasMany
    {
        return $this->hasMany(SubIssue::class);
    }
}
