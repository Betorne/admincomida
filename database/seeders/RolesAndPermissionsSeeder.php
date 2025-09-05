<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1) Crear permisos
        $perms = [
            'view companies', 'create companies', 'edit companies', 'delete companies',
            'view workers',   'create workers',   'edit workers',   'delete workers',
            'view services',  'view reports',
        ];
        foreach ($perms as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 2) Crear roles y asignar permisos
        $admin = Role::firstOrCreate(['name'=>'admin']);
        $admin->givePermissionTo(Permission::all());

        $hr = Role::firstOrCreate(['name'=>'hr']);
        $hr->givePermissionTo([
            'view workers','create workers','edit workers','delete workers',
            'view companies',
        ]);

        $manager = Role::firstOrCreate(['name'=>'manager']);
        $manager->givePermissionTo([
            'view reports','view workers','view companies','view services',
        ]);
    }
}
