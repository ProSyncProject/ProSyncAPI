<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sprint extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unique_id',
        'name',
        'goal',
        'description',
        'project_id',
        'start_date',
        'end_date',
        'completed_at',
    ];

    protected array $dates = [
        'start_date',
        'end_date',
        'completed_at',
    ];

    /**
     * Get the project that owns the sprint.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
