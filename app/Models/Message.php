<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'unique_id',
        'channel_id',
        'user_id',
        'parent_id',
        'content',
        'forwarded',
        'pinned_at',
    ];

    protected $appends = [
        'is_pinned',
        'is_saved',
        'is_seen'
    ];

    /**
     * Get the channel that owns the message.
     *
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Get the user that owns the message.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for the message.
     *
     * @return HasMany
     */
    public function replies() : HasMany
    {
        return $this->hasMany(Message::class, 'parent_id');
    }

    /**
     * Get the seen log for the message.
     *
     * @return HasMany
     */
    public function seenLogs() : HasMany
    {
        return $this->hasMany(MessageSeen::class);
    }

    /**
     * Get the saves for the message.
     *
     * @return HasMany
     */
    public function saves() : HasMany
    {
        return $this->hasMany(MessageSave::class);
    }

    /**
     * If the message is pinned or not.
     *
     * @return bool
     */
    public function getIsPinnedAttribute() : bool
    {
        return !is_null($this->pinned_at);
    }

    /**
     * If the authenticated user has saved the message.
     *
     * @return bool
     */
    public function getIsSavedAttribute() : bool
    {
        return $this->saves()->where('user_id', auth()->id())->exists();
    }

    /**
     * If the message is seen by the authenticated user.
     *
     * @return bool
     */
    public function getIsSeenAttribute() : bool
    {
        return $this->seenLogs()->where('user_id', auth()->id())->exists();
    }
}
