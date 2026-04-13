<?php

namespace App\Domains\Ministry\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToChurch;

class MinistryJoinRequest extends Model
{
    use BelongsToChurch;

    protected $fillable = [
        'ministry_id',
        'user_id',
        'skills_note',
        'availability',
        'status',
    ];

    protected $casts = [
        'availability' => 'array',
    ];

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   