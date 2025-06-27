<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'preferred_language',
        'dark_mode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'dark_mode' => 'boolean',
        ];
    }

    /**
     * Get messages sent by this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by this user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all messages (sent and received) for this user.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id')
            ->orWhere('receiver_id', $this->id);
    }

    /**
     * Get the latest message between this user and another user.
     */
    public function latestMessageWith(User $user)
    {
        return Message::betweenUsers($this->id, $user->id)
            ->latest()
            ->first();
    }

    /**
     * Get unread messages count from a specific user.
     */
    public function unreadMessagesFrom(User $user): int
    {
        return Message::where('sender_id', $user->id)
            ->where('receiver_id', $this->id)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get groups created by this user.
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    /**
     * Get groups this user is a member of.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')
                    ->withPivot(['is_admin', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get groups this user is an admin of.
     */
    public function adminGroups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')
                    ->wherePivot('is_admin', true)
                    ->withPivot(['is_admin', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get group messages sent by this user.
     */
    public function groupMessages(): HasMany
    {
        return $this->hasMany(GroupMessage::class, 'sender_id');
    }

    /**
     * Check if user is member of a group.
     */
    public function isMemberOf(Group $group): bool
    {
        return $this->groups()->where('group_id', $group->id)->exists();
    }

    /**
     * Check if user is admin of a group.
     */
    public function isAdminOf(Group $group): bool
    {
        return $this->groups()
                    ->where('group_id', $group->id)
                    ->wherePivot('is_admin', true)
                    ->exists();
    }
}
