<?php
namespace App\Domains\EGroups\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class EGroupUser extends Pivot
{
    use HasUuids;

    // This tells Laravel the table name since it's not the plural of the model
    protected $table = 'egroup_user';

    // Important: Pivot models need this for UUIDs to work correctly
    public $incrementing = false;
    protected $keyType = 'string';

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
}