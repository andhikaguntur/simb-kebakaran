// app.js

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
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (!data || !data.features) {
                populateFireTable([]);
                return;
            }

            const features = data.features.slice(); // copy
            features.sort((a, b) => {
                const aKey = (a.properties.acq_date || '') + (a.properties.acq_time || '');
                const bKey = (b.properties.acq_date || '') + (b.properties.acq_time || '');
                return bKey.localeCompare(aKey);
            });

            features.forEach(f => {
                const c = f.geometry.coordinates;
                L.marker([c[1], c[0]], { icon: fireIcon }).addTo(map)
                    .bindPopup(`<strong>${f.properties.location}</strong><br>${f.properties.acq_date} ${f.properties.acq_time || ''}<br>Conf: ${f.properties.confidence}%`);
            });

            populateFireTable(features);
        })
        .catch(error => {
            console.error('Fetch error:', error);
            populateFireTable([]);
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
