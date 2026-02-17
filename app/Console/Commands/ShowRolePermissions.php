<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class ShowRolePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:show {role? : The role name to display}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display role permissions summary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->argument('role');

        if ($roleName) {
            $this->showSingleRole($roleName);
        } else {
            $this->showAllRoles();
        }

        return 0;
    }

    private function showAllRoles()
    {
        $this->info('🔐 ROLES & PERMISSIONS SUMMARY');
        $this->newLine();

        $roles = Role::with('permissions')->get();

        $tableData = [];
        foreach ($roles as $role) {
            $tableData[] = [
                'name' => $role->name,
                'permissions' => $role->permissions->count(),
                'note' => $this->getRoleNote($role->name),
            ];
        }

        $this->table(
            ['Role', 'Permissions', 'Note'],
            $tableData
        );

        $this->newLine();
        $this->info('💡 Use: php artisan role:show {role} to see detailed permissions');
    }

    private function showSingleRole(string $roleName)
    {
        $role = Role::where('name', $roleName)->with('permissions')->first();

        if (!$role) {
            $this->error("Role '{$roleName}' not found!");
            return;
        }

        $this->info("👤 {$role->name} Role");
        $this->info(str_repeat('=', 50));
        $this->newLine();

        if ($role->permissions->isEmpty()) {
            $this->warn('No permissions assigned to this role.');
            return;
        }

        // Group permissions by resource
        $grouped = $role->permissions->groupBy(function ($permission) {
            // Extract resource name from permission (e.g., 'view_product' -> 'product')
            $parts = explode('_', $permission->name);
            return implode('_', array_slice($parts, 1)); // Remove first part (action)
        });

        foreach ($grouped as $resource => $permissions) {
            $this->line("📦 <fg=yellow>{$resource}</>");
            foreach ($permissions as $permission) {
                $this->line("   ✓ {$permission->name}");
            }
            $this->newLine();
        }

        $this->info("Total: {$role->permissions->count()} permissions");
    }

    private function getRoleNote(string $roleName): string
    {
        return match ($roleName) {
            'super_admin' => 'Full access (via Gate)',
            'admin' => 'Full management access',
            'manager' => 'Insurance operations',
            'nasabah' => 'Frontend user only',
            default => '-',
        };
    }
}
