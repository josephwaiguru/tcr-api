<?php

namespace App\Domains\Church\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Church extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'location',
    ];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    public function members()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'church_user',
            'church_id',
            'user_id'
        );
    }
}
