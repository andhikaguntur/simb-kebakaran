<?php
session_start();
include 'includes/db.php';

//  Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data titik api
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

// Prepared statement: cari berdasar kolom `location` jika q ada
if ($q !== '') {
    $stmt = $conn->prepare("SELECT * FROM firepoints WHERE location LIKE CONCAT('%', ?, '%') ORDER BY acq_date DESC");
    $stmt->bind_param('s', $q);
} else {
    $stmt = $conn->prepare("SELECT * FROM firepoints ORDER BY acq_date DESC");
}

$stmt->execute();
$result = $stmt->get_result();

// Tarik semua row ke array agar bisa dipakai berkali-kali
$firepoints = [];
while ($row = $result->fetch_assoc()) {
    $firepoints[] = $row;
}

$firepoints_count = count($firepoints);
$high_confidence_count = 0;
foreach ($firepoints as $row) {
    if ((int)$row['confidence'] >= 80) {
        $high_confidence_count++;
    }
}
$stmt->close();

//hitung status siaga
$alert_level = 'AMAN';
$alert_class = 'success';
$alert_icon  = 'check-circle';

if ($high_confidence_count >= 15 ) {
    $alert_level = 'BAHAYA';
    $alert_class = 'danger';
    $alert_icon  = 'exclamation-triangle';
} elseif ($high_confidence_count >= 8 ) {
    $alert_level = 'WASPADA';
    $alert_class = 'warning';
    $alert_icon  = 'exclamation-circle';
} elseif ($high_confidence_count >= 3) {
    $alert_level = 'SIAGA';
    $alert_class = 'info';
    $alert_icon  = 'info-circle';
}


include 'includes/header.php';
?>

<section class="data-section py-5">
    <div class="container-fluid">
        <!-- Header & Admin Info -->
        <div class="text-center mb-4">
            <h2 class="page-title">
                <i class="fas fa-user-shield"></i> Panel Admin
            </h2>
            <div class="mt-2">
                <span class="badge bg-secondary px-3 py-2 me-2">
                    <i class="fas fa-user me-1"></i> <?= htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <span class="badge bg-<?= $_SESSION['user_role'] === 'admin' ? 'danger' : 'primary'; ?> px-3 py-2">
                    <i class="fas fa-shield-alt me-1"></i> <?= strtoupper($_SESSION['user_role']); ?>
                </span>
            </div>
        </div>

        <!-- Statistik Cards - 3 Column -->
        <div class="row justify-content-center g-4 mb-4">
            <!-- Total Titik Api -->
            <div class="col-xl-3 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: fit-content">
                            <i class="fas fa-fire fa-2x text-warning"></i>
                        </div>
                        <h3 class="mb-1 fw-bold"><?= $firepoints_count; ?></h3>
                        <p class="text-muted mb-0 small">Total Titik Api</p>
                    </div>
                </div>
            </div>

            <!-- Confidence Tinggi -->
            <div class="col-xl-3 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: fit-content">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                        <h3 class="mb-1 fw-bold"><?= $high_confidence_count; ?></h3>
                        <p class="text-muted mb-0 small">Confidence Tinggi</p>
                        <small class="text-danger">≥80% confidence</small>
                    </div>
                </div>
            </div>

            <!-- Status Siaga -->
            <div class="col-xl-3 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-<?= $alert_class; ?> bg-opacity-10 rounded-circle p-3 mx-auto mb-3" style="width: fit-content">
                            <i class="fas fa-<?= $alert_icon; ?> fa-2x text-<?= $alert_class; ?>"></i>
                        </div>
                        <h3 class="mb-1 fw-bold text-<?= $alert_class; ?>"><?= $alert_level; ?></h3>
                        <p class="text-muted mb-0 small">Status Siaga</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Status - Centered -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="alert alert-<?= $alert_class; ?> alert-dismissible fade show text-center" role="alert">
                    <i class="fas fa-<?= $alert_icon; ?> me-2"></i>
                    <strong>Status: <?= $alert_level; ?></strong> -
                    <?php
                    switch ($alert_level) {
                        case 'BAHAYA':
                            echo "Terdapat $high_confidence_count titik api dengan confidence tinggi. Tindakan darurat diperlukan!";
                            break;
                        case 'WASPADA':
                            echo "Aktivitas kebakaran meningkat. Tingkatkan patroli dan kesiapsiagaan.";
                            break;
                        case 'SIAGA':
                            echo "Beberapa titik api terdeteksi. Monitor secara berkala.";
                            break;
                        default:
                            echo "Kondisi terkendali. Tetap lakukan monitoring rutin.";
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>

                <!-- Statistik Titik Api -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-fire text-warning me-2"></i> Statistik Titik Api</h6>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Titik Api:</span>
                            <strong class="text-warning"><?= $firepoints_count; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Confidence Tinggi (≥80%):</span>
                            <strong class="text-danger"><?= $high_confidence_count; ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Confidence Rendah (&lt;80%):</span>
                            <strong class="text-info"><?= $firepoints_count - $high_confidence_count; ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sumber Data -->
            <div class="col-md-6">
                <div class="card border-info h-100">
                    <div class="card-body">
                        <h6 class="card-title"><i class="fas fa-satellite text-info me-2"></i> Sumber Data Satelit</h6>
                        <hr>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> NASA FIRMS - MODIS & VIIRS</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Format: GeoJSON, CSV, Shapefile</li>
                            <li><i class="fas fa-check-circle text-success me-2"></i> Update: Near Real-time</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-container">

            <!-- Judul -->
            <div class="mb-3">
                <h4 class="mb-0"><i class="fas fa-table"></i> Daftar Titik Api</h4>
            </div>

            <!-- Search form: full width di bawah judul -->
            <form method="get" action="admin.php" class="mb-3" role="search">
                <div class="input-group">
                    <input id="searchLocation" name="q" type="search"
                           class="form-control form-control-sm"
                           placeholder="Cari lokasi..." aria-label="Cari lokasi"
                           value="<?= htmlspecialchars($q); ?>">
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </div>
            </form>

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($firepoints_count > 0): 
                            $no = 1;
                            foreach ($firepoints as $fp): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($fp['location']); ?></td>
                                <td><?= number_format((float)$fp['latitude'],4); ?></td>
                                <td><?= number_format((float)$fp['longitude'],4); ?></td>
                                <td><?= htmlspecialchars($fp['acq_date']); ?></td>
                                <td><?= htmlspecialchars($fp['confidence']); ?>%</td>
                                <td><?= htmlspecialchars($fp['satellite']); ?></td>
                                <td>
                                    <!-- Edit -->
                                    <button 
                                        class="btn btn-sm btn-warning" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal"
                                        data-id="<?= $fp['id'] ?>"
                                        data-location="<?= htmlspecialchars($fp['location'], ENT_QUOTES) ?>"
                                        data-lat="<?= $fp['latitude'] ?>"
                                        data-lon="<?= $fp['longitude'] ?>"
                                        data-date="<?= $fp['acq_date'] ?>"
                                        data-confidence="<?= $fp['confidence'] ?>"
                                        data-satellite="<?= htmlspecialchars($fp['satellite'], ENT_QUOTES) ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Hapus -->
                                    <form method="POST" action="delete_firepoint.php" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        <input type="hidden" name="id" value="<?= $fp['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach;
                        else: ?>
                            <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>


</section>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="update_firepoint.php" class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Titik Api</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">

        <div class="mb-3">
          <label class="form-label">Lokasi</label>
          <input type="text" name="location" id="edit-location" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Latitude</label>
          <input type="text" name="latitude" id="edit-lat" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Longitude</label>
          <input type="text" name="longitude" id="edit-lon" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal</label>
          <input type="date" name="acq_date" id="edit-date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Confidence (%)</label>
          <input type="number" name="confidence" id="edit-confidence" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Satelit</label>
          <input type="text" name="satellite" id="edit-satellite" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', event => {
  const btn = event.relatedTarget;
  document.getElementById('edit-id').value = btn.dataset.id;
  document.getElementById('edit-location').value = btn.dataset.location;
  document.getElementById('edit-lat').value = btn.dataset.lat;
  document.getElementById('edit-lon').value = btn.dataset.lon;
  document.getElementById('edit-date').value = btn.dataset.date;
  document.getElementById('edit-confidence').value = btn.dataset.confidence;
  document.getElementById('edit-satellite').value = btn.dataset.satellite;
});
</script>


<?php include 'includes/footer.php'; ?>
