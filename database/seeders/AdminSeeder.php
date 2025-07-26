<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BusinessSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      
        $settings = config('system.settings');

        $businessSetting = new BusinessSetting();
        foreach ($settings as $category => $group) {
            if (is_array($group)) {
                foreach ($group as $key => $item) {
                    $value = is_array($item) ? $item['value'] ?? null : $item;
                    $inputType = is_array($item) ? $item['input_type'] ?? 'text' : 'text';

                    $businessSetting->firstOrCreate(
                        ['key' => $key],
                        [
                            'category' => $category,
                            'value' => $value,
                            'input_type' => $inputType,
                        ]
                    );
                }
            } else {
                $businessSetting->firstOrCreate(
                    ['key' => $category],
                    [
                        'category' => null,
                        'value' => $group,
                        'input_type' => 'text',
                    ]
                );
            }
        }

        $user = config('system.user');
        if(User::where('email', $user['email'])->first()){
            return;
        }
        $admin = User::create([
            'is_employee' => $user['is_employee'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => $user['status'],
            'password' => Hash::make($user['password']),
        ]);

        $roles = [
            ucfirst($user['role'])
        ];

        foreach($roles as $role) {
            if(Role::where('name', $role)->first()){
                continue;
            }
            Role::create(
                [
                    'name' => $role,
                    'guard_name' => 'web',
                ]
            );
        }
        $userRole = Role::where('name', ucfirst($user['role']))->first();
        $permissions = include(database_path('seederData/permissions.php'));

        foreach ($permissions as $permission) {
            $underscoreSeparated = explode('-', $permission);
            $label = str_replace('_', ' ', $underscoreSeparated[0]);
            $exists = DB::table('permissions')
                ->where('label', $label)
                ->where('name', $permission)
                ->exists();

            if ($exists) {
                continue;
            }
            Permission::create([
                'label' => $label,
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
        // Assign Permissions and Role "Admin User".
        if (isset($userRole) && !empty($userRole) && $userRole->name === 'Admin') {
            $permissions = Permission::get();
            $userRole->givePermissionTo($permissions);
        }
        $admin->assignRole($userRole);
    }
}
