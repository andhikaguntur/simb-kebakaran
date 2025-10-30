<?php
// data.php
// Halaman Peta dan Tabel Titik Api

session_start();
include 'includes/header.php';
?>

<section class="data-section">
    <div class="container-fluid">
        <h2 class="page-title"><i class="fas fa-map-marked-alt"></i> Peta Titik Api & Data Kebakaran</h2>
        
        <!-- Peta -->
        <div class="map-container">
            <div id="map"></div>
        </div>
        
        <!-- Info -->
        <div class="data-info">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Sumber Data:</strong> NASA FIRMS (Fire Information for Resource Management System) - MODIS & VIIRS Hotspot Data. 
                        Data dapat diunduh dari <a href="https://firms.modaps.eosdis.nasa.gov/" target="_blank">https://firms.modaps.eosdis.nasa.gov/</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabel Data -->
        <div class="table-container">
            <h4><i class="fas fa-table"></i> Daftar Titik Api</h4>
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
    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="app.js"></script>

<?php include 'includes/footer.php'; ?>