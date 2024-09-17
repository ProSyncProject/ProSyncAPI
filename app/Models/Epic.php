<?php

namespace App\Models;

use App\Observers\EpicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([EpicObserver::class])]
class Epic extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'issue_number', 'unique_id', 'project_id'];

    /**
     * The project that the epic belongs to
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The issues associated with the epic
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * Get the identifier for the epic.
     *
     * @return MorphOne
     */
    public function identifier(): MorphOne
    {
        return $this->morphOne(Identifier::class, 'identifiable');
    }
}
