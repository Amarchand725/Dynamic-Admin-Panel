<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\BusinessSetting;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            $user['role']
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
        $userRole = Role::where('name', $user['role'])->first();
        $permissions = include(config_path('seederData/permissions.php'));

        foreach ($permissions as $permission) {
            $underscoreSeparated = explode('-', $permission);
            $label = str_replace('_', ' ', $underscoreSeparated[0]);
            if(Permission::where('label', $label)->where('name', $permission)->first()){
                continue;
            }
            Permission::create([
                'label' => $label,
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
        // Assign Permissions and Role "Admin User".
        if(isset($userRole) && !empty($userRole) && $userRole=='admin'){
            $permissions = Permission::get();
            $userRole->givePermissionTo($permissions);
        }
        $admin->assignRole($userRole);
    }
}
