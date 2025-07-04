<?php

$inputFile = __DIR__ . '/database/seederData/cities.json'; // your full cities.json path
$outputDir = __DIR__ . '/database/seederData/splits';
$chunkSize = 10000; // how many cities per file

if (!file_exists($inputFile)) {
    exit("❌ cities.json not found at: $inputFile\n");
}

if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
}

echo "Reading JSON...\n";
$data = json_decode(file_get_contents($inputFile), true);

if (!$data || !is_array($data)) {
    exit("❌ Invalid JSON file or too large to decode\n");
}

echo "Splitting into chunks of $chunkSize...\n";

$chunks = array_chunk($data, $chunkSize);
foreach ($chunks as $i => $chunk) {
    $fileName = $outputDir . "/cities_part_" . ($i + 1) . ".json";
    file_put_contents($fileName, json_encode($chunk, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "✅ Created: $fileName\n";
}

echo "🎉 Done! Total parts: " . count($chunks) . "\n";
