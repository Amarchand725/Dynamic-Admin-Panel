<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SplitCitiesJson extends Command
{
    protected $signature = 'cities:split {--chunk=1000}';
    protected $description = 'Split large cities.json into smaller chunk files';

    public function handle()
    {
        $sourcePath = database_path('seederData/cities.json');
        $outputDir = database_path('seederData/splits');

        if (!File::exists($sourcePath)) {
            $this->error("Source file not found at: $sourcePath");
            return;
        }

        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        $json = File::get($sourcePath);
        $cities = json_decode($json, true);

        if (!is_array($cities)) {
            $this->error("Invalid JSON format.");
            return;
        }

        $chunkSize = (int) $this->option('chunk');
        $chunks = array_chunk($cities, $chunkSize);

        foreach ($chunks as $index => $chunk) {
            $fileName = $outputDir . "/cities_" . ($index + 1) . ".json";
            File::put($fileName, json_encode($chunk, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("Created: $fileName");
        }

        $this->info("✅ Done! Split into " . count($chunks) . " files.");
    }
}