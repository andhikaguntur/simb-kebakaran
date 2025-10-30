<?php
// mitigasi.php
// Halaman Mitigasi Lengkap

session_start();
include 'includes/header.php';
?>

<section class="mitigasi-section">
    <div class="container">
        <h2 class="page-title"><i class="fas fa-shield-alt"></i> Mitigasi Kebakaran Hutan & Lahan</h2>
        
        <div class="mitigasi-content">
            <div class="mitigasi-block">
                <h3><i class="fas fa-exclamation-triangle"></i> Pengertian Mitigasi</h3>
                <p>Mitigasi kebakaran hutan dan lahan adalah serangkaian upaya untuk mengurangi risiko dan dampak kebakaran melalui tindakan pencegahan, kesiapsiagaan, tanggap darurat, dan pemulihan pasca bencana.</p>
            </div>
            
            <div class="mitigasi-block">
                <h3><i class="fas fa-tasks"></i> Tahapan Mitigasi</h3>
                
                <div class="accordion" id="mitigasiAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pra">
                                1. Pra Bencana (Pencegahan & Kesiapsiagaan)
                            </button>
                        </h2>
                        <div id="pra" class="accordion-collapse collapse show" data-bs-parent="#mitigasiAccordion">
                            <div class="accordion-body">
                                <h6>Pencegahan:</h6>
                                <ul>
                                    <li>Sosialisasi dan edukasi masyarakat tentang bahaya membakar lahan</li>
                                    <li>Penegakan hukum terhadap pelaku pembakaran</li>
                                    <li>Pembangunan sekat bakar dan kanal air di lahan gambut</li>
                                    <li>Patroli rutin di area rawan kebakaran</li>
                                    <li>Pembuatan peraturan larangan membakar lahan</li>
                                </ul>
                                
                                <h6>Kesiapsiagaan:</h6>
                                <ul>
                                    <li>Pembentukan tim tanggap darurat kebakaran</li>
                                    <li>Penyediaan peralatan pemadam kebakaran</li>
                                    <li>Pelatihan pemadaman untuk masyarakat dan relawan</li>
                                    <li>Pembuatan peta rawan bencana</li>
                                    <li>Sistem deteksi dini menggunakan satelit dan drone</li>
                                    <li>Instalasi menara pengawas (fire tower)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#saat">
                                2. Saat Bencana (Tanggap Darurat)
                            </button>
                        </h2>
                        <div id="saat" class="accordion-collapse collapse" data-bs-parent="#mitigasiAccordion">
                            <div class="accordion-body">
                                <h6>Tindakan Pemadaman:</h6>
                                <ul>
                                    <li><strong>Water Bombing:</strong> Pengeboman air menggunakan helikopter untuk area luas</li>
                                    <li><strong>Penyemprotan Air:</strong> Menggunakan pompa dan selang pemadam</li>
                                    <li><strong>Pembukaan Sekat Bakar:</strong> Membuat jalur kosong untuk memutus api</li>
                                    <li><strong>Pembasahan Lahan:</strong> Membasahi area sekitar untuk mencegah perluasan</li>
                                    <li><strong>Pemadam Manual:</strong> Tim darat memadamkan dengan alat tradisional</li>
                                </ul>
                                
                                <h6>Evakuasi:</h6>
                                <ul>
                                    <li>Evakuasi masyarakat dari area terdampak kabut asap</li>
                                    <li>Penyediaan posko kesehatan dan masker</li>
                                    <li>Koordinasi dengan BPBD dan instansi terkait</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pasca">
                                3. Pasca Bencana (Rehabilitasi & Rekonstruksi)
                            </button>
                        </h2>
                        <div id="pasca" class="accordion-collapse collapse" data-bs-parent="#mitigasiAccordion">
                            <div class="accordion-body">
                                <h6>Rehabilitasi Lahan:</h6>
                                <ul>
                                    <li>Reboisasi dengan tanaman endemik</li>
                                    <li>Restorasi lahan gambut yang terbakar</li>
                                    <li>Pemulihan kesuburan tanah</li>
                                    <li>Pengaturan tata air lahan gambut</li>
                                </ul>
                                
                                <h6>Pemulihan Sosial Ekonomi:</h6>
                                <ul>
                                    <li>Bantuan bagi masyarakat terdampak</li>
                                    <li>Pendampingan alternatif mata pencaharian</li>
                                    <li>Program penguatan ekonomi lokal</li>
                                </ul>
                                
                                <h6>Evaluasi & Pembelajaran:</h6>
                                <ul>
                                    <li>Analisis penyebab dan dampak kebakaran</li>
                                    <li>Perbaikan sistem deteksi dan respon</li>
                                    <li>Dokumentasi untuk pembelajaran masa depan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mitigasi-block">
                <h3><i class="fas fa-users"></i> Peran Masyarakat</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="role-card">
                            <h5><i class="fas fa-ban"></i> Yang Harus Dihindari</h5>
                            <ul>
                                <li>Membakar lahan untuk pembukaan lahan pertanian</li>
                                <li>Membuang puntung rokok sembarangan di area hutan</li>
                                <li>Membuat api unggun tanpa pengawasan</li>
                                <li>Membakar sampah di musim kemarau</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="role-card">
                            <h5><i class="fas fa-check-circle"></i> Yang Harus Dilakukan</h5>
                            <ul>
                                <li>Melaporkan asap atau api ke nomor darurat 113/119</li>
                                <li>Ikut serta dalam patroli dan pengawasan</li>
                                <li>Menggunakan metode pertanian ramah lingkungan</li>
                                <li>Menjaga kelestarian hutan dan lahan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mitigasi-block">
                <h3><i class="fas fa-phone-alt"></i> Kontak Darurat</h3>
                <div class="emergency-contacts">
                    <div class="contact-item">
                        <i class="fas fa-fire-extinguisher"></i>
                        <strong>Pemadam Kebakaran:</strong> 113
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-ambulance"></i>
                        <strong>Ambulans/SAR:</strong> 119
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-hospital"></i>
                        <strong>Polisi:</strong> 110
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-building"></i>
                        <strong>BPBD:</strong> Hubungi BPBD daerah setempat
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>