<?php
// admin.php
session_start();
include 'includes/db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data reports
$reports_query = "SELECT r.*, u.name as user_name FROM reports r 
                  LEFT JOIN users u ON r.user_id = u.id 
                  ORDER BY r.report_date DESC LIMIT 20";
$reports_result = $conn->query($reports_query);

// 🔄 Ambil data dari API lokal (bukan dari file)
$firepoints_query = "SELECT * FROM firepoints";
$firepoints_result = $conn->query($firepoints_query);

$firepoints_count = $firepoints_result->num_rows;
$high_confidence_count = 0;

while ($row = $firepoints_result->fetch_assoc()) {
    if ((int)$row['confidence'] >= 80) {
        $high_confidence_count++;
    }
}


// Hitung jumlah laporan dalam 24 jam terakhir
$recent_reports_query = "SELECT COUNT(*) as count FROM reports WHERE report_date >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
$recent_reports_result = $conn->query($recent_reports_query);
$recent_reports = $recent_reports_result->fetch_assoc()['count'];

// Tentukan Alert Level berdasarkan titik api confidence tinggi dan laporan terbaru
$alert_level = 'AMAN';
$alert_class = 'success';
$alert_icon = 'check-circle';

if ($high_confidence_count >= 15 || $recent_reports >= 10) {
    $alert_level = 'BAHAYA';
    $alert_class = 'danger';
    $alert_icon = 'exclamation-triangle';
} elseif ($high_confidence_count >= 8 || $recent_reports >= 5) {
    $alert_level = 'WASPADA';
    $alert_class = 'warning';
    $alert_icon = 'exclamation-circle';
} elseif ($high_confidence_count >= 3 || $recent_reports >= 2) {
    $alert_level = 'SIAGA';
    $alert_class = 'info';
    $alert_icon = 'info-circle';
}

include 'includes/header.php';
?>

<section class="py-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-fire-red mb-0">
                <i class="fas fa-user-shield"></i> Panel Admin
            </h2>
            <div>
                <span class="badge bg-secondary me-2">
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <span class="badge bg-<?php echo $_SESSION['user_role'] === 'admin' ? 'danger' : 'primary'; ?>">
                    <?php echo strtoupper($_SESSION['user_role']); ?>
                </span>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-fire fa-2x text-danger"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold"><?php echo $reports_result->num_rows; ?></h3>
                            <p class="text-muted mb-0 small">Laporan Kebakaran</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-map-marker-alt fa-2x text-warning"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold"><?php echo $firepoints_count; ?></h3>
                            <p class="text-muted mb-0 small">Titik Api Terdeteksi</p>
                            <?php if ($high_confidence_count > 0): ?>
                            <small class="text-danger">
                                <i class="fas fa-fire"></i> <?php echo $high_confidence_count; ?> prioritas tinggi
                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 border-start border-<?php echo $alert_class; ?> border-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-<?php echo $alert_class; ?> bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-<?php echo $alert_icon; ?> fa-2x text-<?php echo $alert_class; ?>"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold text-<?php echo $alert_class; ?>"><?php echo $alert_level; ?></h3>
                            <p class="text-muted mb-0 small">Status Siaga</p>
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> <?php echo $recent_reports; ?> laporan (24 jam)
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Alert Level -->
        <div class="alert alert-<?php echo $alert_class; ?> alert-dismissible fade show" role="alert">
            <i class="fas fa-<?php echo $alert_icon; ?> me-2"></i>
            <strong>Status: <?php echo $alert_level; ?></strong> - 
            <?php
            switch($alert_level) {
                case 'BAHAYA':
                    echo 'Terdapat ' . $high_confidence_count . ' titik api dengan confidence tinggi. Tindakan darurat diperlukan!';
                    break;
                case 'WASPADA':
                    echo 'Aktivitas kebakaran meningkat. Tingkatkan patroli dan kesiapsiagaan.';
                    break;
                case 'SIAGA':
                    echo 'Beberapa titik api terdeteksi. Monitor secara berkala.';
                    break;
                default:
                    echo 'Kondisi terkendali. Tetap lakukan monitoring rutin.';
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button">
                    <i class="fas fa-file-alt"></i> Laporan <span class="badge bg-danger ms-1"><?php echo $reports_result->num_rows; ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button">
                    <i class="fas fa-database"></i> Data Titik Api
                </button>
            </li>
        </ul>
        
        <div class="tab-content bg-white rounded shadow-sm p-4" id="adminTabsContent">
            
            <!-- Tab Reports -->
            <div class="tab-pane fade" id="reports" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-file-alt text-danger"></i> Laporan Kebakaran</h5>
                    <div>
                        <span class="badge bg-success me-2"><?php echo $recent_reports; ?> laporan baru (24 jam)</span>
                        <button class="btn btn-sm btn-outline-primary" onclick="window.location.reload()">
                            <i class="fas fa-sync"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">User</th>
                                <th width="20%">Lokasi</th>
                                <th width="30%">Deskripsi</th>
                                <th width="15%">Koordinat</th>
                                <th width="15%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($reports_result->num_rows > 0): ?>
                                <?php 
                                $reports_result->data_seek(0);
                                while ($report = $reports_result->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td><span class="badge bg-secondary">#<?php echo $report['id']; ?></span></td>
                                    <td>
                                        <i class="fas fa-user text-muted me-1"></i>
                                        <?php echo htmlspecialchars($report['user_name']); ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <?php echo htmlspecialchars($report['location']); ?>
                                    </td>
                                    <td>
                                        <small><?php echo htmlspecialchars(substr($report['description'], 0, 80)) . '...'; ?></small>
                                    </td>
                                    <td>
                                        <?php if($report['latitude'] && $report['longitude']): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-crosshairs me-1"></i>
                                                <?php echo number_format($report['latitude'], 4); ?>, 
                                                <?php echo number_format($report['longitude'], 4); ?>
                                            </small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($report['report_date'])); ?>
                                        </small>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada laporan kebakaran
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tab Data -->
            <div class="tab-pane fade" id="data" role="tabpanel">
                <h5 class="mb-4"><i class="fas fa-database text-warning"></i> Sumber Data Titik Api</h5>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-fire text-warning me-2"></i>
                                    Statistik Titik Api
                                </h6>
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Titik Api:</span>
                                    <strong class="text-warning"><?php echo $firepoints_count; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Confidence Tinggi (≥80%):</span>
                                    <strong class="text-danger"><?php echo $high_confidence_count; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Confidence Rendah (<80%):</span>
                                    <strong class="text-info"><?php echo $firepoints_count - $high_confidence_count; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-satellite text-info me-2"></i>
                                    Sumber Data Satelit
                                </h6>
                                <hr>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>NASA FIRMS</strong> - MODIS & VIIRS
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Format: GeoJSON, CSV, Shapefile
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Update: Near Real-time
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>NASA FIRMS:</strong> 
                    <a href="https://firms.modaps.eosdis.nasa.gov/download/" target="_blank" class="alert-link">
                        https://firms.modaps.eosdis.nasa.gov/download/
                    </a>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-file-code text-primary me-2"></i>File Data Lokal</h6>
                        <p class="mb-3">
                            <code>data/firepoints.geojson</code>
                            <span class="badge bg-success ms-2">
                                <i class="fas fa-check"></i> <?php echo $firepoints_count; ?> titik api
                            </span>
                        </p>
                        <a href="data/firepoints.geojson" class="btn btn-primary btn-sm" download>
                            <i class="fas fa-download"></i> Download GeoJSON
                        </a>
                        <a href="data.php" class="btn btn-outline-primary btn-sm ms-2">
                            <i class="fas fa-map"></i> Lihat di Peta
                        </a>
                    </div>
                </div>
            </div>
</section>

<?php include 'includes/footer.php'; ?>