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
        foreach($settings as $key=>$setting){
            if(BusinessSetting::where('key', $key)->first()){
                continue;
            }
            BusinessSetting::create([
                'key' => $key,
                'value' => config('system.settings.'.$key),
            ]);
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
