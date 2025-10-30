<?php
// about.php
session_start();
include 'includes/header.php';
?>

<section class="about-section">
    <div class="container">
        <h2 class="page-title"><i class="fas fa-info-circle"></i> About Me</h2>
        
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="profile-card">
                    <div class="profile-image">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Nama Pembuat</h3>
                    <p class="text-muted">Web Developer</p>
                    <div class="social-links">
                        <a href="#" title="Email"><i class="fas fa-envelope"></i></a>
                        <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                        <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            
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
                        <strong>Mata Kuliah:</strong> [Nama Mata Kuliah]<br>
                        <strong>Dosen:</strong> [Nama Dosen]<br>
                        <strong>Universitas:</strong> [Nama Universitas]<br>
                        <strong>Tahun:</strong> 2024/2025
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