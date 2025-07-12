<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            [
                'menu_group' => Null,
                'group_order' => 0,
                'icon' => 'ti ti-home',
                'items' => [
                    [
                        'menu' => 'menu',
                        'menu_label' => 'Menu',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'icon', 'label' => 'Icon', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'categorized_by', 'label' => 'Categorized By', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'menu_group', 'label' => 'Menu Group', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'menu', 'label' => 'Menu', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'menu_label', 'label' => 'Menu Label', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'fields', 'label' => 'Menu Fields', 'data_type' => 'text', 'input_type' => 'textarea'],
                            ['name' => 'status', 'label' => 'Status', 'data_type' => 'boolean', 'input_type' => 'select'],
                            ['name' => 'created_at', 'label' => 'Created At', 'data_type' => 'string', 'input_type' => 'string'],
                            ['name' => 'created_by', 'label' => 'Created By', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'select'],
                        ]
                    ]
                ],
            ],
            [
                'menu_group' => 1,
                'group_order' => 1,
                'icon' => 'ti ti-users',
                'items' => [
                    [
                        'menu' => 'user',
                        'menu_label' => 'Users',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'name', 'label' => 'Name', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'email', 'label' => 'Email', 'data_type' => 'string', 'input_type' => 'email'],
                            ['name' => 'role', 'label' => 'Role', 'data_type' => 'string', 'input_type' => 'select'],
                            ['name' => 'created_at', 'label' => 'Created At', 'data_type' => 'string', 'input_type' => 'string'],
                            ['name' => 'created_by', 'label' => 'Created By', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'select'],
                        ]
                    ]
                ],
            ],
            [
                'menu_group' => 1,
                'group_order' => 2,
                'icon' => 'ti ti-settings',
                'items' => [
                    [
                        'menu' => 'setting',
                        'menu_label' => 'General Settings',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'key', 'label' => 'key', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'value', 'label' => 'value', 'data_type' => 'text', 'input_type' => 'textarea'],
                        ]
                    ]
                ],
            ],
            [
                'menu_group' => 1,
                'group_order' => 3,
                'icon' => 'ti ti-settings',
                'items' => [
                    [
                        'menu' => 'role',
                        'menu_label' => 'Roles',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'name', 'label' => 'Name', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'guard_name', 'label' => 'Guard Name', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'status', 'label' => 'Status', 'data_type' => 'boolean', 'input_type' => 'select'],
                            ['name' => 'created_at', 'label' => 'Created At', 'data_type' => 'string', 'input_type' => 'string'],
                            ['name' => 'created_by', 'label' => 'Created By', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'select'],
                        ]
                    ]
                ],
            ],
            [
                'menu_group' => 1,
                'group_order' => 4,
                'icon' => 'ti ti-settings',
                'items' => [
                    [
                        'menu' => 'permission',
                        'menu_label' => 'Permissions',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'label', 'label' => 'Label', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'name', 'label' => 'Name', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'guard_name', 'label' => 'Guard Name', 'data_type' => 'text', 'input_type' => 'text'],
                            ['name' => 'created_at', 'label' => 'Created At', 'data_type' => 'string', 'input_type' => 'string'],
                            ['name' => 'created_by', 'label' => 'Created By', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'select'],
                        ]
                    ]
                ],
            ],
            [
                'menu_group' => 1,
                'group_order' => 5,
                'icon' => 'ti ti-settings',
                'items' => [
                    [
                        'menu' => 'log',
                        'menu_label' => 'Logs',
                        'menu_order' => 0,
                        'fields' => [
                            ['name' => 'user_id', 'label' => 'User', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'model', 'label' => 'Model', 'data_type' => 'text', 'input_type' => 'text'],
                            ['name' => 'model_id', 'label' => 'Model ID', 'data_type' => 'integer', 'input_type' => 'select'],
                            ['name' => 'changed_fields', 'label' => 'Updated Fields', 'data_type' => 'text', 'input_type' => 'textarea'],
                            ['name' => 'ip_address', 'label' => 'IP Address', 'data_type' => 'string', 'input_type' => 'text'],
                            ['name' => 'description', 'label' => 'Description', 'data_type' => 'text', 'input_type' => 'textarea'],
                            ['name' => 'extra_details', 'label' => 'Extra Details', 'data_type' => 'text', 'input_type' => 'textarea'],
                            ['name' => 'created_at', 'label' => 'Created At', 'data_type' => 'string', 'input_type' => 'string'],
                            ['name' => 'action', 'label' => 'Action', 'data_type' => 'string', 'input_type' => 'select'],
                        ]
                    ]
                ],
            ],
        ];

        foreach ($menus as $groupIndex => $group) {
            foreach ($group['items'] as $menuIndex => $item) {
                $menuId = DB::table('menus')->insertGetId([
                    'created_by' => 1,
                    'menu_group' => $group['menu_group'],
                    'menu' => $item['menu'],
                    'menu_label' => $item['menu_label'],
                    'group_order' => $group['group_order'],
                    'menu_order' => $item['menu_order'],
                    'priority' => null,
                    'icon' => $group['icon'],
                    'categorized_by' => 'Administration',
                    'status' => 1,
                    'fields' => json_encode($item['fields']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($item['fields'] as $field) {
                    $extra = [];
                    if ($field['input_type'] === 'string') {
                        $extra['validation'] = 'max:255';
                    } elseif ($field['input_type'] === 'text') {
                        $extra['validation'] = NULL;
                    }

                    $extraValidation = NULL;
                    if (count($extra) > 0) {
                        $extraValidation = json_encode($extra);
                    }

                    DB::table('menu_fields')->insert([
                        'menu_id' => $menuId,
                        'name' => $field['name'],
                        'label' => $field['label'],
                        'data_type' => $field['data_type'],
                        'input_type' => $field['input_type'],
                        'placeholder' => $field['label'],
                        'required' => false,
                        'index_visible' => true,
                        'create_visible' => true,
                        'edit_visible' => true,
                        'show_visible' => true,
                        'extra' => $extraValidation,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}