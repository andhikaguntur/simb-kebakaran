<?php
// includes/header.php
// Header yang digunakan di semua halaman

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMB - Sistem Informasi Manajemen Bahaya Kebakaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>

<body>
    <!-- Header Fixed -->
    <header class="header-fixed">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-fire-alt"></i> SIMB Kebakaran
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Awal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="data.php"><i class="fas fa-map-marked-alt"></i> Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mitigasi.php"><i class="fas fa-shield-alt"></i> Mitigasi</a>
                        </li>
                        <?php if (isset($_SESSION['user_role'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="admin.php"><i class="fas fa-user-shield"></i> Admin</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php"><i class="fas fa-info-circle"></i> About Us</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="content-wrapper">