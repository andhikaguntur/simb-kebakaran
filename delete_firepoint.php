<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $conn->query("DELETE FROM firepoints WHERE id = '$id'");
    echo "<script>alert('Data berhasil dihapus'); window.location='admin.php';</script>";
}
?>
