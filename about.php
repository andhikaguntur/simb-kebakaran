<?php
// about.php
session_start();
include 'includes/header.php';
?>

<section class="about-section">
   <div class="container my-5">
    <h2 class="page-title"><i class="fas fa-info-circle"></i> About Us</h2>

    <div class="row">
        <!-- Kolom kiri untuk profil -->
        <div class="col-md-4">
            <div class="d-flex flex-column gap-3">

                <!-- PROFIL ATAS (statis) -->
                <div class="profile-card text-center">
                    <div class="profile-image">
    <img src="asset/guntur.png" alt="Foto Profil Utama" class="img-fluid rounded-circle" style="width:170px; object-fit:cover;">
</div>
                    <h3>Guntur(ketua)</h3>
                    <p class="text-muted">Web Developer</p>
                    <div class="social-links">
                        <a href="https://wa.me/6281281108030" title="Email"><i class="fas fa-envelope"></i></a>
                        <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                        <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>

                <!-- PROFIL BAWAH (carousel) -->
                <div id="teamCarousel" class="carousel slide profile-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        <!-- Profil 1 -->
                        <div class="carousel-item active">
                            <div class="profile-card text-center">
                                <div class="profile-image">
    <img src="asset/guntur.png" alt="Foto Profil Utama" class="img-fluid rounded-circle" style="width:170px; object-fit:cover;">
</div>
                                <h3>budak 1</h3>
                                <p class="text-muted">Front-End Developer</p>
                                <div class="social-links">
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Profil 2 -->
                        <div class="carousel-item">
                            <div class="profile-card text-center">
                               <div class="profile-image">
    <img src="asset/guntur.png" alt="Foto Profil Utama" class="img-fluid rounded-circle" style="width:170px; object-fit:cover;">
</div>
                                <h3>budak 2</h3>
                                <p class="text-muted">Back-End Developer</p>
                                <div class="social-links">
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Profil 3 -->
                        <div class="carousel-item">
                            <div class="profile-card text-center">
                              <div class="profile-image">
    <img src="asset/guntur.png" alt="Foto Profil Utama" class="img-fluid rounded-circle" style="width:170px; object-fit:cover;">
</div>
                                <h3>budak 3</h3>
                                <p class="text-muted">UI/UX Designer</p>
                                <div class="social-links">
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <!-- Profil 4 -->
                        <div class="carousel-item">
                            <div class="profile-card text-center">
                              <div class="profile-image">
    <img src="asset/guntur.png" alt="Foto Profil Utama" class="img-fluid rounded-circle" style="width:170px; object-fit:cover;">
</div>
                                <h3>budak 4</h3>
                                <p class="text-muted">Data Analyst</p>
                                <div class="social-links">
                                    <a href="#"><i class="fas fa-envelope"></i></a>
                                    <a href="#"><i class="fab fa-github"></i></a>
                                    <a href="#"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Navigasi -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- CARD TERIMA KASIH -->
<div class="thanks-card text-center">
    <h4>Thank You.</h4>

</div>


            </div>
        </div>

        <!-- Kolom kanan untuk about content -->
        <div class="col-md-8">
            <div class="about-content">
                <h4><i class="fas fa-project-diagram"></i> Tentang Proyek</h4>
                <p>SIMB (Sistem Informasi Manajemen Bahaya) Kebakaran adalah aplikasi web yang dikembangkan untuk membantu dalam pemantauan, analisis, dan mitigasi kebakaran hutan dan lahan di Indonesia.</p>
                
                <h4 class="mt-4"><i class="fas fa-bullseye"></i> Tujuan</h4>
                <ul>
                    <li>Menyediakan informasi real-time mengenai titik api</li>
                    <li>Memfasilitasi pelaporan kebakaran oleh masyarakat</li>
                    <li>Memberikan edukasi mengenai pencegahan dan mitigasi kebakaran</li>
                    <li>Membantu koordinasi penanganan darurat kebakaran</li>
                </ul>
                
                <h4 class="mt-4"><i class="fas fa-cogs"></i> Teknologi</h4>
                <div class="tech-stack">
                    <span class="badge bg-primary">HTML5</span>
                    <span class="badge bg-primary">CSS3</span>
                    <span class="badge bg-primary">JavaScript</span>
                    <span class="badge bg-warning">PHP</span>
                    <span class="badge bg-info">MySQL</span>
                    <span class="badge bg-success">Bootstrap 5</span>
                    <span class="badge bg-danger">Leaflet.js</span>
                </div>

                <h4 class="mt-4"><i class="fas fa-database"></i> Sumber Data</h4>
                <ul>
                    <li><strong>NASA FIRMS:</strong> Fire Information for Resource Management System
                        <br><small class="text-muted">https://firms.modaps.eosdis.nasa.gov/</small>
                    </li>
                    <li><strong>OpenStreetMap:</strong> Peta dasar open-source
                        <br><small class="text-muted">https://www.openstreetmap.org/</small>
                    </li>
                </ul>

                <h4 class="mt-4"><i class="fas fa-graduation-cap"></i> Informasi Akademis</h4>
                <p>
                    <strong>Mata Kuliah:</strong> Sistem Informasi Manajemen Bencana<br>
                    <strong>Dosen:</strong> Herry Sofyan<br>
                    <strong>Universitas:</strong> Universitas Pembangunan Nasional "Veteran" Yogyakarta<br>
                    <strong>Tahun:</strong> 2025/2026
                </p>

                <h4 class="mt-4"><i class="fas fa-envelope"></i> Kontak</h4>
                <p>
                    Email: <a href="mailto:email@example.com">email@example.com</a><br>
                    GitHub: <a href="https://github.com/username" target="_blank">github.com/username</a>
                </p>
            </div>
        </div>
    </div>
</div>

</section>

<?php include 'includes/footer.php'; ?>