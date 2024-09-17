<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Identifier extends Model
{
    use SoftDeletes, HasUniqueId;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'issue_number',
        'project_id',
        'identifiable_id',
        'identifiable_type',
    ];

    /**
     * Get the parent identifier model
     *
     * @return MorphTo
     */
    public function identifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the project that owns the Identifier
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
