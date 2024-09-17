<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChannelUser extends Pivot
{
    protected $fillable = [
        'channel_id',
        'user_id',
        'is_creator',
    ];

    protected $casts = [
        'is_creator' => 'boolean',
    ];

    /**
     * Get the user that belongs to the channel.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the channel that belongs to the user.
     *
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
