<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = config('app.default_user_password', 'password');

        $this->ensureRole('admin');
        $this->ensureRole('manager');
        $this->ensureRole('nasabah');

        $this->createUserWithRole([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@local.com',
            'email_verified_at' => now(),
            'password' => Hash::make($defaultPassword),
        ], 'admin');

        $this->createUserWithRole([
            'username' => 'manager',
            'firstname' => 'Manager',
            'lastname' => 'User',
            'email' => 'manager@local.com',
            'email_verified_at' => now(),
            'password' => Hash::make($defaultPassword),
        ], 'manager');

        $this->createUserWithRole([
            'username' => 'nasabah',
            'firstname' => 'Nasabah',
            'lastname' => 'User',
            'email' => 'nasabah@local.com',
            'email_verified_at' => now(),
            'password' => Hash::make($defaultPassword),
        ], 'nasabah');
    }

    private function createUserWithRole(array $attributes, string $roleName): void
    {
        $user = User::firstOrCreate(
            ['email' => $attributes['email']],
            array_merge($attributes, ['id' => (string) Str::uuid()])
        );

        if (! $user->hasRole($roleName)) {
            $user->assignRole($roleName);
        }
    }

    private function ensureRole(string $roleName): void
    {
        Role::updateOrCreate(
            ['name' => $roleName, 'guard_name' => 'web'],
            ['updated_at' => now()]
        );
    }
}
