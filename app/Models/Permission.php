<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model
{
    private static array $ACTIONS = ['create', 'read', 'update', 'delete'];

    private static array $CanCalls = [];

    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'actions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public static function scopeForUser($query, $user)
    {
        return $query->where('role_id', $user->role_id);
    }
}
