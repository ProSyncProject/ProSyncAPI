<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes, HasUniqueId;

    protected $fillable = [
        'unique_id',
        'name',
        'description',
        'project_id',
        'privacy',
    ];

    protected $appends = ['is_seen'];

    /**
     * Get the project that owns the channel.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the users for the channel.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ChannelUser::class)
            ->withTimestamps()
            ->withPivot('is_creator');
    }

    /**
     * Get the messages for the channel.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Check if the last message is seen.
     *
     * @return bool
     */
    public function getIsSeenAttribute(): bool
    {
        return $this->messages->last()->is_seen;
    }
}
