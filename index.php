<?php
// index.php
// Halaman Utama dengan 3 Cuplikan

session_start();
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="hero-title animate-fade-in">Sistem Informasi Manajemen Bahaya Kebakaran</h1>
        <p class="hero-subtitle animate-fade-in-delay">Memantau, Menganalisis, dan Mitigasi Kebakaran Hutan & Lahan</p>
        <a href="data.php" class="btn btn-hero animate-fade-in-delay-2">
            <i class="fas fa-map-marked-alt"></i> Lihat Peta Titik Api
        </a>
    </div>
</section>

<!-- Card Section -->
<section class="cards-section">
    <div class="container">
        <div class="row g-4">
            <!-- Card 1: Pengertian -->
            <div class="col-md-4">
                <div class="info-card" data-bs-toggle="modal" data-bs-target="#modalPengertian">
                    <div class="card-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <h3>Pengertian Kebakaran</h3>
                    <p>Memahami definisi, jenis, dan dampak kebakaran hutan dan lahan...</p>
                    <span class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                </div>
            </div>

            <!-- Card 2: Data -->
            <div class="col-md-4">
                <div class="info-card" data-bs-toggle="modal" data-bs-target="#modalData">
                    <div class="card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Data Kebakaran</h3>
                    <p>Statistik dan informasi terkini mengenai titik api di Indonesia...</p>
                    <span class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                </div>
            </div>

            <!-- Card 3: Mitigasi -->
            <div class="col-md-4">
                <div class="info-card" data-bs-toggle="modal" data-bs-target="#modalMitigasi">
                    <div class="card-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>Mitigasi Bencana</h3>
                    <p>Langkah-langkah pencegahan dan penanganan kebakaran hutan...</p>
                    <span class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Pengertian -->
<div class="modal fade" id="modalPengertian" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-fire"></i> Pengertian Kebakaran Hutan & Lahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Definisi</h6>
                <p>Kebakaran hutan dan lahan (karhutla) adalah kebakaran yang terjadi di kawasan hutan dan lahan yang dapat disebabkan oleh faktor alam maupun aktivitas manusia. Kebakaran ini dapat menimbulkan kerugian ekonomi, ekologi, dan sosial yang sangat besar.</p>
                
                <h6>Jenis Kebakaran</h6>
                <ul>
                    <li><strong>Kebakaran Permukaan:</strong> Membakar serasah dan tumbuhan bawah</li>
                    <li><strong>Kebakaran Tajuk:</strong> Membakar bagian atas pohon</li>
                    <li><strong>Kebakaran Bawah Tanah:</strong> Membakar lapisan gambut atau humus</li>
                </ul>
                
                <h6>Penyebab Utama</h6>
                <ul>
                    <li>Pembukaan lahan dengan cara membakar (slash and burn)</li>
                    <li>Pembuangan puntung rokok sembarangan</li>
                    <li>Faktor cuaca kering dan kemarau panjang</li>
                    <li>Petir dan sambaran listrik alami</li>
                </ul>
                
                <h6>Dampak</h6>
                <p>Kebakaran hutan menimbulkan dampak serius seperti polusi udara (kabut asap), kerusakan ekosistem, hilangnya keanekaragaman hayati, gangguan kesehatan masyarakat, dan kerugian ekonomi miliaran rupiah setiap tahunnya.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Data -->
<div class="modal fade" id="modalData" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-chart-line"></i> Data Kebakaran Hutan & Lahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Statistik Kebakaran</h6>
                <p>Indonesia mengalami kebakaran hutan dan lahan setiap tahunnya, terutama di musim kemarau. Provinsi dengan kejadian tertinggi meliputi Kalimantan, Sumatera, dan Papua.</p>
                
                <h6>Sumber Data</h6>
                <ul>
                    <li><strong>NASA FIRMS:</strong> Fire Information for Resource Management System menggunakan satelit MODIS dan VIIRS untuk mendeteksi titik panas (hotspot) secara real-time</li>
                    <li><strong>LAPAN:</strong> Lembaga Penerbangan dan Antariksa Nasional menyediakan data pemantauan kebakaran</li>
                    <li><strong>KLHK:</strong> Kementerian Lingkungan Hidup dan Kehutanan melakukan monitoring wilayah rawan kebakaran</li>
                </ul>
                
                <h6>Interpretasi Titik Panas</h6>
                <p><strong>Confidence Level:</strong> Tingkat keyakinan deteksi hotspot</p>
                <ul>
                    <li>Rendah (0-30%): Kemungkinan bukan kebakaran</li>
                    <li>Sedang (30-80%): Potensi kebakaran</li>
                    <li>Tinggi (80-100%): Sangat mungkin kebakaran aktif</li>
                </ul>
                
                <p class="mt-3">Lihat peta interaktif di menu <a href="data.php">Data</a> untuk informasi detail titik api terkini.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="data.php" class="btn btn-primary">Lihat Peta</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mitigasi -->
<div class="modal fade" id="modalMitigasi" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-hands-helping"></i> Mitigasi Kebakaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Ringkasan Mitigasi</h6>
                <p>Mitigasi kebakaran hutan meliputi upaya pencegahan, kesiapsiagaan, dan penanganan darurat untuk mengurangi risiko dan dampak kebakaran.</p>
                
                <h6>Langkah Utama:</h6>
                <ul>
                    <li><strong>Pencegahan:</strong> Edukasi masyarakat, patroli rutin, larangan membakar lahan</li>
                    <li><strong>Deteksi Dini:</strong> Sistem pemantauan satelit, menara pengawas, aplikasi pelaporan</li>
                    <li><strong>Pemadaman:</strong> Tim tanggap darurat, water bombing, pembukaan sekat bakar</li>
                    <li><strong>Rehabilitasi:</strong> Reboisasi, restorasi lahan gambut, pemulihan ekosistem</li>
                </ul>
                
                <p class="mt-3">Informasi lengkap mengenai mitigasi dapat dilihat di halaman <a href="mitigasi.php">Mitigasi</a>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="mitigasi.php" class="btn btn-primary">Detail Mitigasi</a>
            </div>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'; ?>