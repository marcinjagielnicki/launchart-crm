<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'owner_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    public function scopeWhereOwner(Builder $query, User $user)
    {
        return $query->where('owner_id', $user->id);
    }
}
