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
                            ['field' => 'icon', 'label' => 'Icon', 'type' => 'string', 'input_type' => 'text', 
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'menu_group', 'label' => 'Menu Group', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'menu', 'label' => 'Menu', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => false, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'menu_label', 'label' => 'Menu Label', 'type' => 'string', 'input_type' => 'text',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'fields', 'label' => 'Menu Fields', 'type' => 'text', 'input_type' => 'text',
                                'required' => false, 'index_visible' => false, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'status', 'label' => 'Status', 'type' => 'boolean', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'created_at', 'label' => 'Created At', 'type' => 'string', 'input_type' => 'string',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'created_by', 'label' => 'Created By', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'action', 'label' => 'Action', 'type' => 'string', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
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
                            ['field' => 'name', 'label' => 'Name', 'type' => 'string', 'input_type' => 'text',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'email', 'label' => 'Email', 'type' => 'string', 'input_type' => 'email',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'role', 'label' => 'Role', 'type' => 'string', 'input_type' => 'select',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'created_at', 'label' => 'Created At', 'type' => 'string', 'input_type' => 'string',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'created_by', 'label' => 'Created By', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'action', 'label' => 'Action', 'type' => 'string', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
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
                            ['field' => 'key', 'label' => 'key', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => false, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
                            ['field' => 'value', 'label' => 'value', 'type' => 'text', 'input_type' => 'textarea',
                                'required' => false, 'index_visible' => false, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
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
                            ['field' => 'name', 'label' => 'Name', 'type' => 'string', 'input_type' => 'text',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'guard_name', 'label' => 'Guard Name', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'status', 'label' => 'Status', 'type' => 'boolean', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'created_at', 'label' => 'Created At', 'type' => 'string', 'input_type' => 'string',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'action', 'label' => 'Action', 'type' => 'string', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
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
                            ['field' => 'label', 'label' => 'Label', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'name', 'label' => 'Name', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'guard_name', 'label' => 'Guard Name', 'type' => 'text', 'input_type' => 'text',
                                'required' => true, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'created_at', 'label' => 'Created At', 'type' => 'string', 'input_type' => 'string',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'created_by', 'label' => 'Created By', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'action', 'label' => 'Action', 'type' => 'string', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => false
                            ],
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
                            ['field' => 'user_id', 'label' => 'User', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'user_action', 'label' => 'User Action', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'model', 'label' => 'Model', 'type' => 'text', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'model_id', 'label' => 'Model ID', 'type' => 'integer', 'input_type' => 'select',
                                'required' => false, 'index_visible' => false, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'changed_fields', 'label' => 'Updated Fields', 'type' => 'text', 'input_type' => 'textarea',
                                'required' => false, 'index_visible' => false, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'ip_address', 'label' => 'IP Address', 'type' => 'string', 'input_type' => 'text',
                                'required' => false, 'index_visible' => true, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'description', 'label' => 'Description', 'type' => 'text', 'input_type' => 'textarea',
                                'required' => false, 'index_visible' => false, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'extra_details', 'label' => 'Extra Details', 'type' => 'text', 'input_type' => 'textarea',
                                'required' => false, 'index_visible' => false, 'create_visible' => true, 'edit_visible' => true, 'show_visible' => true
                            ],
                            ['field' => 'created_at', 'label' => 'Created At', 'type' => 'string', 'input_type' => 'string',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
                            ['field' => 'action', 'label' => 'Action', 'type' => 'string', 'input_type' => 'select',
                                'required' => false, 'index_visible' => true, 'create_visible' => false, 'edit_visible' => false, 'show_visible' => true
                            ],
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
                        'name' => $field['field'],
                        'label' => $field['label'],
                        'data_type' => $field['type'],
                        'input_type' => $field['input_type'],
                        'placeholder' => $field['label'],
                        'required' => $field['required'],
                        'index_visible' => $field['index_visible'],
                        'create_visible' => $field['create_visible'],
                        'edit_visible' => $field['edit_visible'],
                        'show_visible' => $field['show_visible'],
                        'extra' => $extraValidation,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}