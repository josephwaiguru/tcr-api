<?php

namespace App\Traits;

use Filament\Facades\Filament;

trait BelongsToChurch
{
    protected static function bootBelongsToChurch()
    {
        static::creating(function ($model) {
            if ($tenant = Filament::getTenant()) {
                $model->church_id = $tenant->id;
            }
        });

        static::addGlobalScope('church', function ($query) {
            if (auth()->check() && ! auth()->user()->hasRole('super_admin') && Filament::getTenant()) {
                $query->where('church_id', Filament::getTenant()->id);
            }
        });
    }
}