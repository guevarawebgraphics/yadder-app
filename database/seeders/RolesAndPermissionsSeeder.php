<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'user']);

        $adminUser = new User([
            'name' => 'Admin',
            'email' => 'admin@domain.com',
            'password' => Hash::make('password'),
        ]);

        $adminUser->save();
        $adminUser->assignRole($adminRole->name);

        $user = new User([
            'name' => 'User',
            'email' => 'user@domain.com',
            'password' => Hash::make('password'),
        ]);

        $user->save();
        $user->assignRole('user');
    }
}
