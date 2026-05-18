<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view-any-task',
            'create-task',
            'edit-any-task',
            'delete-any-task',
            'view-own-task',
            'edit-own-task',
            'delete-own-task',
            'manage-users',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->syncPermissions([
            'view-own-task',
            'edit-own-task',
            'delete-own-task',
        ]);
        
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->assignRole('admin');
    }
}
