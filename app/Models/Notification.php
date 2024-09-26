<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasUniqueId;

    protected $fillable = [
        'unique_id',
        'user_id',
        'title',
        'read_at',
    ];

    protected $appends = [
        'is_read',
    ];

    /**
    * Get the user that owns the Notification
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notificatio as read
     *
     * @return void
     */
    public function markAsRead(): void
    {
        $this->read_at = now();
        $this->save();
    }

    /**
     * Check if the notification has been read
     *
     * @return bool
     */
    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }
}
