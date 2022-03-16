<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Apps extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function loves(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'loves')->withTimestamps();
    }

    public function isLikedBy(?User $user): bool
    {
        return $user
        // userがnullならfalse nullじゃなければカウント
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }
    
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }
}
