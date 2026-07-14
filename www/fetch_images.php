<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

$tools = Tool::all();

foreach ($tools as $tool) {
    // Bersihkan nama alat untuk pencarian (hapus qty, "Modul", dsb)
    $query = $tool->nama_alat;
    $query = preg_replace('/^\d+\s*x\s*/i', '', $query); // Hapus "40x "
    $query = preg_replace('/^\d+\s*pcs\s*/i', '', $query); // Hapus "2pcs "
    $query = preg_replace('/^\d+\s*/i', '', $query); // Hapus "3 Kabel" -> "Kabel"
    
    // Spesifik map
    if (stripos($query, 'Arduino') !== false) $query = 'Arduino';
    if (stripos($query, 'Raspberry') !== false) $query = 'Raspberry Pi';
    if (stripos($query, 'Kabel USB') !== false) $query = 'USB Cable';
    if (stripos($query, 'BreadBoard') !== false) $query = 'Breadboard';
    if (stripos($query, 'Sensor jarak') !== false) $query = 'Ultrasonic sensor';
    if (stripos($query, 'Kabel Jumper') !== false) $query = 'Jump wire';
    if (stripos($query, 'Header Pin') !== false) $query = 'Pin header';
    if (stripos($query, 'LED') !== false && stripos($query, 'OLED') === false) $query = 'Light-emitting diode';
    if (stripos($query, 'Resistor') !== false) $query = 'Resistor';
    if (stripos($query, 'Potensio') !== false) $query = 'Potentiometer';
    if (stripos($query, 'Buzzer') !== false) $query = 'Buzzer';
    if (stripos($query, 'LCD') !== false) $query = 'Liquid-crystal display';
    if (stripos($query, 'Relay') !== false) $query = 'Relay';
    if (stripos($query, 'Motor servo') !== false || stripos($query, 'Motor Servo') !== false) $query = 'Servo motor';
    if (stripos($query, 'Motor DC') !== false) $query = 'DC motor';
    if (stripos($query, 'Crimping tool') !== false) $query = 'Crimping (joining)';
    if (stripos($query, 'Wifi') !== false) $query = 'Wireless router';
    if (stripos($query, 'Cable Tester') !== false) $query = 'Cable tester';
    if (stripos($query, 'Obeng') !== false) $query = 'Screwdriver';
    if (stripos($query, 'Baterai Holder') !== false) $query = 'Battery holder';
    if (stripos($query, 'Smart Car') !== false) $query = 'Robot car';
    if (stripos($query, 'ESP8266') !== false) $query = 'ESP8266';
    if (stripos($query, 'ESP32') !== false) $query = 'ESP32';
    if (stripos($query, 'Solder') !== false) $query = 'Soldering iron';
    if (stripos($query, 'Pinset') !== false) $query = 'Tweezers';
    if (stripos($query, 'OLED') !== false) $query = 'OLED';
    if (stripos($query, 'RFID') !== false) $query = 'Radio-frequency identification';
    
    echo "Searching for: " . $query . "\n";
    
    $searchUrl = "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=" . urlencode($query) . "&utf8=&format=json&srlimit=2";
    $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($searchUrl);
    
    if ($response->successful()) {
        $results = $response->json('query.search');
        if (!empty($results)) {
            $found = false;
            foreach ($results as $res) {
                $title = $res['title'];
                $imgUrl = "https://en.wikipedia.org/w/api.php?action=query&prop=pageimages&format=json&piprop=original&titles=" . urlencode($title);
                $imgRes = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($imgUrl);
                if ($imgRes->successful()) {
                    $pages = $imgRes->json('query.pages');
                    foreach ($pages as $p) {
                        if (isset($p['original']['source'])) {
                            $src = $p['original']['source'];
                            if (str_ends_with(strtolower($src), '.svg')) continue; // prefer images
                            
                            $ext = pathinfo($src, PATHINFO_EXTENSION);
                            $filename = "wiki_" . Str::slug($query) . "_" . uniqid() . "." . $ext;
                            $filepath = __DIR__ . '/storage/app/public/alat/' . $filename;
                            
                            $imgData = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($src)->body();
                            file_put_contents($filepath, $imgData);
                            
                            $tool->update(['foto_alat' => 'alat/' . $filename]);
                            echo " -> Downloaded: $filename\n";
                            continue 3;
                        }
                    }
                }
            }
            if (!$found && !empty($results)) {
                // If only SVG found, just use the first one
                $title = $results[0]['title'];
                $imgUrl = "https://en.wikipedia.org/w/api.php?action=query&prop=pageimages&format=json&piprop=original&titles=" . urlencode($title);
                $imgRes = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($imgUrl);
                if ($imgRes->successful()) {
                    $pages = $imgRes->json('query.pages');
                    foreach ($pages as $p) {
                        if (isset($p['original']['source'])) {
                            $src = $p['original']['source'];
                            $ext = pathinfo($src, PATHINFO_EXTENSION);
                            // Some files don't have standard extensions, fallback to jpg
                            if (strlen($ext) > 4 || empty($ext)) $ext = 'jpg';
                            $filename = "wiki_" . Str::slug($query) . "_" . uniqid() . "." . $ext;
                            $filepath = __DIR__ . '/storage/app/public/alat/' . $filename;
                            
                            $imgData = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->get($src)->body();
                            file_put_contents($filepath, $imgData);
                            
                            $tool->update(['foto_alat' => 'alat/' . $filename]);
                            echo " -> Downloaded (SVG/Fallback): $filename\n";
                            $found = true;
                            break 2;
                        }
                    }
                }
            }
        } else {
            echo " -> No results found.\n";
        }
    }
    sleep(1); // be polite to wiki API
}

echo "Done.\n";
