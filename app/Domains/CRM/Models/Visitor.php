<?php
namespace App\Domains\CRM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Domains\Church\Models\Church;

class Visitor extends Model
{
    use HasUuids;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'residence',
        'prayer_request',
        'converted_to_user',
    ];

    public function tenant()
    {
        return $this->belongsTo(Church::class, 'church_id');
    }
}   