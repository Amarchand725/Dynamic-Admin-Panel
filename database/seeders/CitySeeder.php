<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('cities')->truncate();
        Schema::enableForeignKeyConstraints();

        $cityFiles = glob(database_path('seederData/splits/cities_part_*.json'));

        foreach ($cityFiles as $filePath) {
            echo "Seeding: $filePath\n";

            $cities = json_decode(file_get_contents($filePath), true);

            foreach (array_chunk($cities, 1000) as $chunk) {
                DB::table('cities')->insert(array_map(function ($city) {
                    return [
                        'state_id' => $city['state_id'],
                        'name' => $city['name'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $chunk));
            }
        }

        echo "✅ All split files imported successfully.\n";
    }
}