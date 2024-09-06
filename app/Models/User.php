<?php

namespace App\Models;

use AchyutN\LaravelComment\Traits\CanComment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, CanComment;

    /**
     * The attributes that are guarded against mass assignment.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     */
    protected $appends = ['full_name'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        if ($this->middle_name) {
            return "{$this->first_name} {$this->middle_name} {$this->last_name}";
        } else {
            return "{$this->first_name} {$this->last_name}";
        }
    }

    /**
     * Get the user's OTP codes.
     *
     * @return HasMany
     */
    public function otpCodes(): HasMany
    {
        return $this->hasMany(Otp::class);
    }

    /**
     * Get the projects that the user is a member of.
     *
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->using(ProjectUser::class)->withPivot('role')->withTimestamps();
    }

    /**
     * The issues asssigned to the user.
     *
     * @return HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'assignee_id');
    }

    /**
     * The issues created by the user.
     *
     * @return HasMany
     */
    public function createdIssues(): HasMany
    {
        return $this->hasMany(Issue::class, 'reporter_id');
    }

    /**
     * The sub-issues asssigned to the user.
     *
     * @return HasMany
     */
    public function subIssues(): HasMany
    {
        return $this->hasMany(SubIssue::class, 'assignee_id');
    }

    /**
     * The sub-issues created by the user.
     *
     * @return HasMany
     */
    public function createdSubIssues(): HasMany
    {
        return $this->hasMany(SubIssue::class, 'reporter_id');
    }
}
