<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the users associated with the project
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(ProjectUser::class)->withPivot('role');
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

}
