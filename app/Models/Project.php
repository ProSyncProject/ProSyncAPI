<?php

namespace App\Models;

use AchyutN\LaravelComment\Traits\HasComment;
use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * The issues associated with the project
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
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
