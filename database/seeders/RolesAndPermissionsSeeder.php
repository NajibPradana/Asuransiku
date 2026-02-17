<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    private bool $forceSync = false;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->forceSync = filter_var(env('ROLE_SYNC_FORCE', false), FILTER_VALIDATE_BOOL);

        // Ensure permissions are generated on fresh environments
        Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
        ]);

        // Create essential custom permissions
        $customPermissions = [
            'access_log_viewer',
        ];

        foreach ($customPermissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission, 'guard_name' => 'web'],
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create roles
        $roles = [
            "super_admin",
            "admin",
            "manager",
            "nasabah",
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role, 'guard_name' => 'web'],
                ['updated_at' => now()]
            );
        }

        // Setup Super Admin - Has access to everything (handled by Gate::before in AuthServiceProvider)
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            if ($this->forceSync) {
                $superAdminRole->syncPermissions(['access_log_viewer']);
            } else {
                $superAdminRole->givePermissionTo(['access_log_viewer']);
            }
            $this->command->info('✓ Super Admin: Full access granted (via Gate)');
        }

        // Setup Manager - Limited access
        $this->setupManagerPermissions();

        // Setup Admin - Full access except super admin features
        $this->setupAdminPermissions();

        // Setup Nasabah - Frontend user
        $nasabahRole = Role::where('name', 'nasabah')->first();
        if ($nasabahRole) {
            // Nasabah tidak memerlukan permissions untuk backend admin panel
            $this->command->info('✓ Nasabah: Role created (no admin permissions)');
        }
    }

    /**
     * Setup Manager Role Permissions
     * Manager can access:
     * - Dashboard (no special permission needed)
     * - Product: Full CRUD
     * - Policy: View Only (data filled by Nasabah)
     * - Claim: View Only (data filled by Nasabah)
     */
    private function setupManagerPermissions(): void
    {
        $managerRole = Role::where('name', 'manager')->first();
        
        if (!$managerRole) {
            $this->command->warn('Manager role not found!');
            return;
        }

        // Overwrite permissions to keep roles consistent across environments

        // Product permissions - Full CRUD
        $productPermissions = [
            'view_product',
            'view_any_product',
            'create_product',
            'update_product',
            'delete_product',
            'delete_any_product',
            'restore_product',
            'restore_any_product',
            'force_delete_product',
            'force_delete_any_product',
        ];

        // Policy permissions - View Only
        $policyPermissions = [
            'view_policy',
            'view_any_policy',
        ];

        // Claim permissions - View Only
        $claimPermissions = [
            'view_claim',
            'view_any_claim',
        ];

        // Combine all permissions for manager
        $allManagerPermissions = array_merge(
            $productPermissions,
            $policyPermissions,
            $claimPermissions
        );

        // Give permissions to manager
        $managerPermissions = Permission::whereIn('name', $allManagerPermissions)->get();
        if ($this->forceSync) {
            $managerRole->syncPermissions($managerPermissions);
        } else {
            $managerRole->givePermissionTo($managerPermissions);
        }

        $this->command->info('✓ Manager: Product (Full CRUD), Policy (View Only), Claim (View Only)');
    }

    /**
     * Setup Admin Role Permissions
     * Admin has access to most features except super admin specific ones
     */
    private function setupAdminPermissions(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        
        if (!$adminRole) {
            $this->command->warn('Admin role not found!');
            return;
        }

        // Overwrite permissions to keep roles consistent across environments

        // Get all insurance-related permissions
        $insurancePermissions = Permission::query()
            ->where('guard_name', 'web')
            ->where(function ($query) {
                $query->where('name', 'like', '%_product')
                    ->orWhere('name', 'like', '%_policy')
                    ->orWhere('name', 'like', '%_claim');
            })
            ->pluck('name')
            ->toArray();

        // Get all user management permissions
        $userPermissions = Permission::query()
            ->where('guard_name', 'web')
            ->where('name', 'like', '%_user')
            ->pluck('name')
            ->toArray();

        // Get content management permissions
        $contentPermissions = Permission::query()
            ->where('guard_name', 'web')
            ->where(function ($query) {
                $query->where('name', 'like', '%_blog%')
                    ->orWhere('name', 'like', '%_banner%')
                    ->orWhere('name', 'like', '%_contact%');
            })
            ->pluck('name')
            ->toArray();

        // Combine permissions for admin
        $allAdminPermissions = array_merge(
            $insurancePermissions,
            $userPermissions,
            $contentPermissions,
            ['access_log_viewer']
        );

        // Give permissions to admin
        $adminPermissions = Permission::whereIn('name', $allAdminPermissions)->get();
        if ($this->forceSync) {
            $adminRole->syncPermissions($adminPermissions);
        } else {
            $adminRole->givePermissionTo($adminPermissions);
        }

        $this->command->info('✓ Admin: Full access to insurance, users, and content management');
    }
}
