<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StateSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('states')->truncate();
        Schema::enableForeignKeyConstraints();

        $states = json_decode(file_get_contents(database_path('seederData/states.json')), true);

        foreach ($states as $state) {
            DB::table('states')->insert([
                'country_id' => $state['country_id'],
                'name' => $state['name'],
                'iso2' => $state['state_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}