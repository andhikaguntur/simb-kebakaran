<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $lat = $_POST['latitude'];
    $lon = $_POST['longitude'];
    $date = $_POST['acq_date'];
    $conf = $_POST['confidence'];
    $sat = $_POST['satellite'];

    $query = $conn->prepare("
        UPDATE firepoints 
        SET location=?, latitude=?, longitude=?, acq_date=?, confidence=?, satellite=?
        WHERE id=?");
    $query->bind_param("sssdisi", $location, $lat, $lon, $date, $conf, $sat, $id);
    $query->execute();

    echo "<script>alert('Data berhasil diperbarui'); window.location='admin.php';</script>";
}
?>
