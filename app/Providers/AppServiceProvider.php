<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Permission;
use App\Models\Role;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app(PermissionRegistrar::class)
            ->setPermissionClass(Permission::class)
            ->setRoleClass(Role::class);

        
        $this->formatShieldPolicies();

        // Grant "super_admin" role all permissions globally.
        // This bypasses the need for specific church_id assignments in the database.
        Gate::before(function ($user, $ability) {
            return $user->hasRole(config('filament-shield.super_admin.name', 'super_admin')) ? true : null;
        });

        // For your in-app resources' models you can add the following method in the boot() method to automatically enforce policies, without the need to manually register each policy.
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            return str_replace('Models', 'Policies', $modelClass) . 'Policy';
        });

        // Ensure base global roles exist
        $this->ensureGlobalRoleExists('admin');
        $this->ensureGlobalRoleExists('leader');
        $this->ensureGlobalRoleExists('member');
    }

    private function formatShieldPolicies(): void
    {
        FilamentShield::buildPermissionKeyUsing(
            function (string $entity, string $affix, string $subject, string $case, string $separator) {
            if (is_subclass_of($entity, Resource::class) && in_array(
                    needle: $entity, 
                    haystack: [
                        'App\Filament\Resources\Blog\Categories\CategoryResource',
                        'App\Filament\Resources\Shop\Categories\CategoryResource'
                    ],
                    strict: true
            )) {
                $subject = str($subject)
                    ->prepend($entity::getNavigationGroup())
                    ->trim()
                    ->toString();
            }

            return FilamentShield::defaultPermissionKeyBuilder(
                affix: $affix, 
                separator: $separator, 
                subject: $subject, 
                case: $case
            );
        }
        );    
    }

    private function ensureGlobalRoleExists(string $name): void
    {
        if(! Schema::hasTable('roles')) {
            return;
        }
        
        $exists = Role::withoutGlobalScopes()
            ->where('name', $name)
            ->where('guard_name', 'web')
            ->whereNotNull('church_id')
            ->exists();

        if (! $exists) {
            $role = new Role();
            $role->name = $name;
            $role->guard_name = 'web';
            $role->church_id = null;
            $role->save();
        }
    }
}
