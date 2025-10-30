<?php
header('Content-Type: application/json');

$apiKey = "b3b3083320d2b01865ee9058bade2306";
$url = "https://firms.modaps.eosdis.nasa.gov/api/area/csv/$apiKey/MODIS_NRT/[95,-11,141,6]/10";

// Ambil data CSV dari NASA FIRMS
$data = @file_get_contents($url);
if (!$data) {
    echo json_encode(["type" => "FeatureCollection", "features" => [], "error" => "Gagal mengambil data dari FIRMS"]);
    exit;
}

// Parse CSV
$rows = array_map("str_getcsv", explode("\n", trim($data)));
$header = array_shift($rows);
$features_raw = [];

foreach ($rows as $row) {
    if (count($row) !== count($header)) continue;
    $rec = array_combine($header, $row);

    $lat = floatval($rec['latitude'] ?? 0);
    $lon = floatval($rec['longitude'] ?? 0);
    $confidence = intval($rec['confidence'] ?? 0);

    // Filter hanya wilayah Indonesia (bounding box)
    if ($lon < 95 || $lon > 141 || $lat < -11 || $lat > 6) continue;

    // Filter hanya confidence >= 50
    if ($confidence < 50) continue;

    $features_raw[] = [
        'latitude' => $lat,
        'longitude' => $lon,
        'acq_date' => $rec['acq_date'] ?? '',
        'acq_time' => $rec['acq_time'] ?? '',
        'confidence' => $confidence,
        'brightness' => $rec['brightness'] ?? null,
        'satellite' => $rec['satellite'] ?? null,
        'frp' => $rec['frp'] ?? null
    ];
}

// Hapus duplikat berdasarkan koordinat & tanggal
$seen = [];
$features = [];
foreach ($features_raw as $r) {
    $key = round($r['latitude'], 4) . '_' . round($r['longitude'], 4) . '_' . $r['acq_date'];
    if (isset($seen[$key])) continue;
    $seen[$key] = true;

    $features[] = [
        "type" => "Feature",
        "geometry" => [
            "type" => "Point",
            "coordinates" => [$r['longitude'], $r['latitude']]
        ],
        "properties" => [
            "location" => getSimpleLocation($r['latitude'], $r['longitude']),
            "acq_date" => $r['acq_date'],
            "acq_time" => $r['acq_time'],
            "confidence" => $r['confidence'],
            "brightness" => $r['brightness'],
            "satellite" => $r['satellite'],
            "frp" => $r['frp']
        ]
    ];
}

// Batasi jumlah titik (opsional)
$MAX = 2000;
if (count($features) > $MAX) {
    $step = ceil(count($features) / $MAX);
    $sampled = [];
    for ($i = 0; $i < count($features); $i += $step) {
        $sampled[] = $features[$i];
    }
    $features = $sampled;
}

// Output GeoJSON
echo json_encode([
    "type" => "FeatureCollection",
    "features" => array_values($features)
], JSON_PRETTY_PRINT);

// =====================================================
// Fungsi sederhana untuk nama lokasi (versi kamu bisa lebih lengkap)
// =====================================================
function getSimpleLocation($lat, $lon) {
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
?>
