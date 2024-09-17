<?php

namespace App\Models;

use App\Traits\HasUniqueId;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends \AchyutN\LaravelComment\Models\Comment
{
    use HasUniqueId;

    protected $fillable = ['content', 'user_id', 'commentable_id', 'commentable_type'];
}
