<?php
// data.php
session_start();
include 'includes/db.php';

// Ambil data firepoints
$firepoints_query = "SELECT * FROM firepoints";
$firepoints_result = $conn->query($firepoints_query);

$firepoints_count = $firepoints_result->num_rows;
$high_confidence_count = 0;

while ($row = $firepoints_result->fetch_assoc()) {
    if ((int)$row['confidence'] >= 80) {
        $high_confidence_count++;
    }
}

include 'includes/header.php';
?>

<section class="data-section">
    <div class="container-fluid">
        <h2 class="page-title mb-4"><i class="fas fa-map-marked-alt"></i> Peta Titik Api & Data Kebakaran</h2>
        
        <!-- Peta -->
        <div class="map-container mb-4">
            <div id="map"></div>
        </div>
        
      <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-warning h-100">
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
                <div class="card border-info h-100">
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

        <!-- Info Section -->
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>NASA FIRMS:</strong> 
            <a href="https://firms.modaps.eosdis.nasa.gov/download/" target="_blank" class="alert-link">
                https://firms.modaps.eosdis.nasa.gov/download/
            </a>
        </div>

        <!-- Download Section -->
        <div class="card mb-4">
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
            </div>
        </div>
    </div>

        <!-- Tabel Data -->
        <div class="table-container mb-4">
            <h4 class="mb-3"><i class="fas fa-table"></i> Daftar Titik Api</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="fireTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Tanggal</th>
                            <th>Confidence</th>
                            <th>Satelit</th>
                        </tr>
                    </thead>
                    <tbody id="fireTableBody">
                        <tr>
                            <td colspan="7" class="text-center">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

      
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="app.js"></script>

<?php include 'includes/footer.php'; ?>