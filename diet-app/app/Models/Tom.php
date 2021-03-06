<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = [
        'image' => 'image|file'
    ];

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
