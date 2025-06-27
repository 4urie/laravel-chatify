<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_id',
        'sender_id',
        'message',
        'message_type',
        'file_path',
        'file_name',
        'detected_language',
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
     * Get the group this message belongs to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the sender of the message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Check if this message is a text message.
     */
    public function isText(): bool
    {
        return $this->message_type === 'text';
    }

    /**
     * Check if this message is an image.
     */
    public function isImage(): bool
    {
        return $this->message_type === 'image';
    }

    /**
     * Check if this message is a file.
     */
    public function isFile(): bool
    {
        return $this->message_type === 'file';
    }

    /**
     * Get the file URL if this message has a file.
     */
    public function getFileUrl(): ?string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }
} 