// app.js
// JavaScript untuk interaksi peta dan UI (versi real-time NASA FIRMS)

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('map')) {
        initMap();
    }
});

// Fungsi Inisialisasi Peta
function initMap() {
    const map = L.map('map').setView([-2.5, 118], 5);

    // Tile layer OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    // Custom icon
    const fireIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Ambil data dari backend (NASA FIRMS API -> PHP)
    fetch('data/get_firepoints_api.php')
        .then(response => {
            if (!response.ok) throw new Error("Gagal memuat data dari server");
            return response.json();
        })
        .then(data => {
            console.log("Data diterima:", data);

            if (!data.features || data.features.length === 0) {
                console.warn('Tidak ada data titik api ditemukan.');
                document.getElementById('fireTableBody').innerHTML =
                    '<tr><td colspan="7" class="text-center">Tidak ada data titik api</td></tr>';
                return;
            }

            // Tambahkan marker ke peta
            L.geoJSON(data, {
                pointToLayer: function(feature, latlng) {
                    return L.marker(latlng, { icon: fireIcon });
                },
                onEachFeature: function(feature, layer) {
                    const props = feature.properties;
                    const popupContent = `
                        <div style="min-width: 200px;">
                            <h6 style="color: #ff4444; margin-bottom: 10px;">
                                <i class="fas fa-fire"></i> Titik Api
                            </h6>
                            <table style="width: 100%; font-size: 0.9em;">
                                <tr>
                                    <td><strong>Wilayah:</strong></td>
                                    <td>${props.location || 'Tidak diketahui'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>${props.acq_date || 'N/A'}</td>
                                </tr>
                                <tr>
                                    <td><strong>Confidence:</strong></td>
                                    <td>${props.confidence || 'N/A'}%</td>
                                </tr>
                                <tr>
                                    <td><strong>Satelit:</strong></td>
                                    <td>${props.satellite || 'N/A'}</td>
                                </tr>
                                <tr>
                                    <td><strong>FRP:</strong></td>
                                    <td>${props.frp || 'N/A'} MW</td>
                                </tr>
                            </table>
                        </div>
                    `;
                    layer.bindPopup(popupContent);
                }
            }).addTo(map);

            // Tampilkan tabel
            populateFireTable(data.features);
        })
        .catch(error => {
            console.error('Error memuat data titik api:', error);
            document.getElementById('fireTableBody').innerHTML =
                '<tr><td colspan="7" class="text-center text-danger">Gagal memuat data titik api</td></tr>';
        });
}

// Fungsi untuk mengisi tabel
function populateFireTable(features) {
    const tableBody = document.getElementById('fireTableBody');

    if (!features || features.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
        return;
    }

    let html = '';
    features.slice(0, 50).forEach((feature, index) => {
        const props = feature.properties;
        const coords = feature.geometry.coordinates;

        // Warna badge berdasarkan confidence
        let confidenceBadge = 'secondary';
        if (props.confidence >= 80) confidenceBadge = 'danger';
        else if (props.confidence >= 50) confidenceBadge = 'warning';
        else if (props.confidence >= 30) confidenceBadge = 'info';

        html += `
            <tr>
                <td>${index + 1}</td>
                <td>${props.location || 'Tidak diketahui'}</td>
                <td>${coords[1].toFixed(4)}</td>
                <td>${coords[0].toFixed(4)}</td>
                <td>${props.acq_date || 'N/A'}</td>
                <td><span class="badge bg-${confidenceBadge}">${props.confidence || 'N/A'}%</span></td>
                <td>${props.satellite || 'N/A'}</td>
            </tr>
        `;
    });

    tableBody.innerHTML = html;
}

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
