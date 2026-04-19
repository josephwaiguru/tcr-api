<?php
namespace App\Domains\EGroups\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EGroupUser extends Pivot
{
    use HasUuids;

    // This tells Laravel the table name since it's not the plural of the model
    protected $table = 'e_group_user';

    // Important: Pivot models need this for UUIDs to work correctly
    public $incrementing = false;
    protected $keyType = 'string';

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function egroup()
    {
        return $this->belongsTo(\App\Domains\EGroups\Models\EGroup::class);
    }
}