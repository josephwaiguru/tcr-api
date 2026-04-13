<?php
namespace App\Domains\Ministry\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToChurch;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ministry extends Model
{
    use BelongsToChurch;
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'leader_id',
    ];

    public function leader()
    {
        return $this->belongsTo(\App\Models\User::class, 'leader_id');
    }

    public function members()
    {
        return $this->hasMany(MinistryMember::class);
    }

    public function joinRequests()
    {
        return $this->hasMany(MinistryJoinRequest::class);
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Domains\Church\Models\Church::class, 'church_id');
    }
}