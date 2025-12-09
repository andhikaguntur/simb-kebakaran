<?php
include 'includes/db.php';

// Ambil data dari database
$query = "SELECT * FROM firepoints";
$result = $conn->query($query);

$features = [];

while ($row = $result->fetch_assoc()) {
    $features[] = [
        "type" => "Feature",
        "geometry" => [
            "type" => "Point",
            "coordinates" => [
                floatval(trim($row["longitude"])),
                floatval(trim($row["latitude"]))
            ]
        ],
        "properties" => [
            "id" => $row["id"],
            "lokasi" => $row["location"],
            "confidence" => (int)$row["confidence"],
            "tanggal" => $row["acq_date"],
            "satelit" => $row["satellite"]
        ]
    ];
}

$geojson = [
    "type" => "FeatureCollection",
    "features" => $features
];

// Set header untuk download
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="firepoints.geojson"');

echo json_encode($geojson, JSON_PRETTY_PRINT);
exit;
?>
