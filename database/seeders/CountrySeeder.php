<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('countries')->truncate();
        Schema::enableForeignKeyConstraints();

        $countries = json_decode(file_get_contents(database_path('seederData/countries.json')), true);

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country['name'],
                'iso2' => $country['iso2'] ?? null,
                'iso3' => $country['iso3'] ?? null,
                'phone_code' => $country['phonecode'] ?? null,
                'currency' => $country['currency'] ?? null,
                'currency_name' => $country['currency_name'] ?? null,
                'currency_symbol' => $country['currency_symbol'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}