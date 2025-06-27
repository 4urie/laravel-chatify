<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the creator of the group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all members of the group.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot(['is_admin', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get all admin members of the group.
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('is_admin', true)
                    ->withPivot(['is_admin', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get all messages in the group.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(GroupMessage::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest message in the group.
     */
    public function latestMessage(): HasMany
    {
        return $this->hasMany(GroupMessage::class)->latest()->limit(1);
    }

    /**
     * Check if a user is a member of the group.
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if a user is an admin of the group.
     */
    public function isAdmin(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->wherePivot('is_admin', true)->exists();
    }

    /**
     * Check if a user is the creator of the group.
     */
    public function isCreator(User $user): bool
    {
        return $this->created_by === $user->id;
    }

    /**
     * Add a user to the group.
     */
    public function addMember(User $user, bool $isAdmin = false): void
    {
        if (!$this->hasMember($user)) {
            $this->members()->attach($user->id, [
                'is_admin' => $isAdmin,
                'joined_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Remove a user from the group.
     */
    public function removeMember(User $user): void
    {
        $this->members()->detach($user->id);
    }

    /**
     * Promote a user to admin.
     */
    public function promoteToAdmin(User $user): void
    {
        if ($this->hasMember($user)) {
            $this->members()->updateExistingPivot($user->id, ['is_admin' => true]);
        }
    }

    /**
     * Demote an admin to regular member.
     */
    public function demoteAdmin(User $user): void
    {
        if ($this->hasMember($user)) {
            $this->members()->updateExistingPivot($user->id, ['is_admin' => false]);
        }
    }

    /**
     * Get unread message count for a user.
     */
    public function getUnreadCountForUser(User $user): int
    {
        // This would require implementing a read status system for group messages
        // For now, return 0. Can be implemented later with a group_message_reads table
        return 0;
    }
} 