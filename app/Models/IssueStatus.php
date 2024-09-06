<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IssueStatus extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'is_resolved'];

    /**
     * The issues associated with the issue status
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'status_id');
    }
}
