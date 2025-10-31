<?php
//get_firepoints_api.php
header('Content-Type: application/json');
include '../includes/db.php'; // koneksi mysqli

$cache_lifetime = 60 * 10; // cache 10 menit

// Cek kapan terakhir kali data diperbarui
$last_update = $conn->query("SELECT MAX(created_at) AS last_update FROM firepoints")->fetch_assoc()['last_update'];
$is_cache_valid = $last_update && (time() - strtotime($last_update) < $cache_lifetime);

if ($is_cache_valid) {
    // 💾 Data cache masih valid → ambil dari database
    $result = $conn->query("SELECT * FROM firepoints");
    $features = [];
    while ($row = $result->fetch_assoc()) {
        $features[] = [
            "type" => "Feature",
            "geometry" => [
                "type" => "Point",
                "coordinates" => [(float)$row['longitude'], (float)$row['latitude']]
            ],
            "properties" => [
                "location" => $row['location'],
                "acq_date" => $row['acq_date'],
                "acq_time" => $row['acq_time'],
                "confidence" => (int)$row['confidence'],
                "brightness" => (float)$row['brightness'],
                "satellite" => $row['satellite'],
                "frp" => (float)$row['frp']
            ]
        ];
    }

    echo json_encode([
        "source" => "cache",
        "type" => "FeatureCollection",
        "features" => $features
    ], JSON_PRETTY_PRINT);
    exit;
}

// 🛰 Kalau cache sudah expired → ambil ulang dari API
$apiKey = "b3b3083320d2b01865ee9058bade2306";
$url = "https://firms.modaps.eosdis.nasa.gov/api/area/csv/$apiKey/MODIS_NRT/[95,-11,141,6]/10";

$data = @file_get_contents($url);
if (!$data) {
    // kalau gagal ambil dari API, fallback ke cache lama
    $result = $conn->query("SELECT * FROM firepoints");
    $features = [];
    while ($row = $result->fetch_assoc()) {
        $features[] = [
            "type" => "Feature",
            "geometry" => ["type" => "Point", "coordinates" => [(float)$row['longitude'], (float)$row['latitude']]],
            "properties" => $row
        ];
    }
    echo json_encode(["source" => "old_cache", "features" => $features]);
    exit;
}

// Parse CSV dari NASA
$rows = array_map("str_getcsv", explode("\n", trim($data)));
$header = array_shift($rows);
$features_raw = [];

foreach ($rows as $row) {
    if (count($row) !== count($header)) continue;
    $rec = array_combine($header, $row);
    $lat = floatval($rec['latitude'] ?? 0);
    $lon = floatval($rec['longitude'] ?? 0);
    $conf = intval($rec['confidence'] ?? 0);

    if ($lon < 95 || $lon > 141 || $lat < -11 || $lat > 6) continue;
    if ($conf < 50) continue;

    $features_raw[] = [
        'latitude' => $lat,
        'longitude' => $lon,
        'acq_date' => $rec['acq_date'] ?? '',
        'acq_time' => $rec['acq_time'] ?? '',
        'confidence' => $conf,
        'brightness' => $rec['brightness'] ?? null,
        'satellite' => $rec['satellite'] ?? null,
        'frp' => $rec['frp'] ?? null,
        'location' => getSimpleLocation($lat, $lon)
    ];
}

// Simpan hasil baru ke DB
$conn->query("TRUNCATE TABLE firepoints");
$stmt = $conn->prepare("
    INSERT INTO firepoints (latitude, longitude, acq_date, acq_time, confidence, brightness, satellite, frp, location)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$limit = 100;
$count = 0;

foreach ($features_raw as $f) {
    if ($count >= $limit) break;
    $location = getSimpleLocation($f['latitude'], $f['longitude']);

    $stmt->bind_param(
        "ddssidsds",
        $f['latitude'],
        $f['longitude'],
        $f['acq_date'],
        $f['acq_time'],
        $f['confidence'],
        $f['brightness'],
        $f['satellite'],
        $f['frp'],
        $location
    );
    $stmt->execute();
    $count++;
}


// Ambil hasil baru untuk dikirim ke frontend
$result = $conn->query("SELECT * FROM firepoints");
$features = [];
while ($row = $result->fetch_assoc()) {
    $features[] = [
        "type" => "Feature",
        "geometry" => ["type" => "Point", "coordinates" => [(float)$row['longitude'], (float)$row['latitude']]],
        "properties" => $row
    ];
}

echo json_encode([
    "source" => "api_refresh",
    "type" => "FeatureCollection",
    "features" => $features
], JSON_PRETTY_PRINT);

function getSimpleLocation($lat, $lon)
{
    if ($lat >= 2 && $lat <= 6 && $lon >= 95 && $lon <= 98) return 'Aceh';
    if ($lat >= 1 && $lat <= 4 && $lon >= 98 && $lon <= 100) return 'Sumatera Utara';
    if ($lat >= -3 && $lat <= 1 && $lon >= 98 && $lon <= 102) return 'Sumatera Barat';
    if ($lat >= -1 && $lat <= 2 && $lon >= 100 && $lon <= 105) return 'Riau';
    if ($lat >= -5 && $lat <= -2 && $lon >= 102 && $lon <= 106) return 'Sumatera Selatan';
    if ($lat >= -8 && $lat <= -6 && $lon >= 106 && $lon <= 109) return 'Jawa Barat';
    if ($lat >= -8 && $lat <= -6 && $lon >= 108 && $lon <= 112) return 'Jawa Tengah';
    if ($lat >= -9 && $lat <= -6 && $lon >= 111 && $lon <= 115) return 'Jawa Timur';
    if ($lat >= -3 && $lat <= 3 && $lon >= 108 && $lon <= 112) return 'Kalimantan Barat';
    if ($lat >= -4 && $lat <= 1 && $lon >= 110 && $lon <= 116) return 'Kalimantan Tengah';
    if ($lat >= -4 && $lat <= -1 && $lon >= 114 && $lon <= 117) return 'Kalimantan Selatan';
    if ($lat >= -2 && $lat <= 3 && $lon >= 113 && $lon <= 119) return 'Kalimantan Timur';
    if ($lat >= -7 && $lat <= -2 && $lon >= 118 && $lon <= 122) return 'Sulawesi Selatan';
    if ($lat >= -9 && $lat <= 0 && $lon >= 135 && $lon <= 141) return 'Papua';
    return 'Indonesia';
}
