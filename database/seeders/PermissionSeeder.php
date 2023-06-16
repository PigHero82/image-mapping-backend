<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = collect([
            [
                'name'          => 'USER_C',
                'description'   => 'Tambah User',
                'group'         => 'User'
            ],
            [
                'name'          => 'USER_R',
                'description'   => 'Lihat User',
                'group'         => 'User'
            ],
            [
                'name'          => 'USER_U',
                'description'   => 'Ubah User',
                'group'         => 'User'
            ],
            [
                'name'          => 'USER_D',
                'description'   => 'Hapus User',
                'group'         => 'User'
            ]
        ]);

        $permissions_name = [];
        foreach ($permissions as $key => $value) {
            $permissions_name[$key] = $value['name'];
        }

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $roles = ['admin', 'user'];

        foreach ($roles as $key => $role) {
            $data = Role::create(['name' => $role]);

            if ($key === 0) {
                $data->syncPermissions($permissions_name);
            } else {
                $data->syncPermissions([$permissions_name[1]]);
            }
        }
    }
}
