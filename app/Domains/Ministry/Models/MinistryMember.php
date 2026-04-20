<?php

namespace App\Domains\Ministry\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Domains\Ministry\Models\Ministry;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MinistryMember extends Pivot
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ministry_id',
        'user_id',
        'role_id',
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
}