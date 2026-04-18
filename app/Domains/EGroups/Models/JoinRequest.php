<?php
namespace App\Domains\EGroups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\EGroups\Models\EGroup;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JoinRequest extends Model
{
    use HasUuids; // Automatically generates UUID on creation

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'e_group_join_requests';

    protected $fillable = ['e_group_id', 'user_id', 'status', 'notes'];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';

    public function eGroup(): BelongsTo
    {
        return $this->belongsTo(EGroup::class);
    }
}