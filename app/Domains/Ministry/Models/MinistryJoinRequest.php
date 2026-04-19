<?php

namespace App\Domains\Ministry\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Domains\Ministry\Models\Ministry;

class MinistryJoinRequest extends Model
{
    use BelongsToChurch, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ministry_id',
        'user_id',
        'skills_note',
        'availability',
        'status',
        'church_id',
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