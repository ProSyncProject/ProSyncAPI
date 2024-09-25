<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    protected $appends = ['is_seen', 'name', 'type'];

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

    /**
     * Overwrite the name of the channel.
     *
     * @return string|null
     */
    public function getNameAttribute(): string|null
    {
        $dbQuery = DB::table('channels')->where('id', $this->id)->first();

        if ($dbQuery->name) {
            return $dbQuery->name;
        }

        if ($this->project) {
            return $this->name . '(' . $this->project->prefix . ')';
        }

        if ($this->users->count() === 2) {
            return $this->users->where('unique_id', '!=', auth()->user()->unique_id)->first()->full_name;
        }

        return $this->name;
    }

    /**
     * Get the type of the channel.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        $dbQuery = DB::table('channels')->where('id', $this->id)->first();

        if ($dbQuery->name) {
            return 'channel';
        }

        if ($this->users->count() === 2) {
            return 'direct';
        }

        return 'channel';
    }
}
