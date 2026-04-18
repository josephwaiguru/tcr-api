<?php

namespace App\Domains\EGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Domains\EGroups\Models\JoinRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
 
class EGroup extends Model
{
    use HasUuids; // Automatically generates UUID on creation

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'e_groups';

    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'location',
        'meeting_date',
        'meeting_time',
        'phone',
        'email',
    ];

    /**
     * Relationship to the confirmed members.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'e_group_user')
                ->using(EGroupUser::class) // This is the magic link
                ->withPivot('id', 'role_id') // Ensure 'id' is included for UUID support
                ->withTimestamps();  
    }

    /**
     * Relationship to active join requests.
     */
    public function joinRequests(): HasMany
    {
        return $this->hasMany(JoinRequest::class, 'e_group_id');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Domains\Church\Models\Church::class, 'church_id');
    }
}