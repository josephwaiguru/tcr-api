<?php

namespace App\Domains\Ministry\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToChurch;
use App\Models\User;
use App\Domains\Ministry\Models\Ministry;

class MinistryMember extends Model
{
    use BelongsToChurch;

    protected $fillable = [
        'ministry_id',
        'user_id',
        'role',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Domains\Church\Models\Church::class, 'church_id');
    }
}