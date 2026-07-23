document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.querySelector('#map');

    if (!mapElement) return;

    // Initialize map
    const defaultCenter = [11.0, 122.5];
    const defaultZoom = 8;

    const map = L.map('map', { zoomControl: true }).setView(defaultCenter, defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Get locations
    const locations = JSON.parse(mapElement.dataset.locations || '[]');

    const bounds = [];
    const allLocationsBounds = []; // ADD THIS
    const markers = {};

    // Marker creation
    locations.forEach(location => {
        if (!location.latitude || !location.longitude) return;

        const coordinates = [
            Number(location.latitude),
            Number(location.longitude)
        ];

        const color = location.status?.color ?? '#64748b';

        const pinIcon = L.divIcon({
            className: '',
            html: `
                <div style="
                    width:28px;
                    height:28px;
                    background:${color};
                    border:3px solid #fff;
                    border-radius:50% 50% 50% 0;
                    transform:rotate(-45deg);
                    box-shadow:0 2px 8px rgba(0,0,0,.35);
                    position:relative;
                ">
                    <div style="
                        width:10px;
                        height:10px;
                        background:#fff;
                        border-radius:50%;
                        position:absolute;
                        top:6px;
                        left:6px;
                    "></div>
                </div>
            `,
            iconSize: [28, 28],
            iconAnchor: [14, 28],
            popupAnchor: [0, -28]
        });

        const marker = L.marker(coordinates, {
            icon: pinIcon
        }).addTo(map);

        markers[location.id] = marker;

        marker.bindPopup(`
    <div style="min-width:240px">

        <div style="
            display:flex;
            align-items:center;
            gap:8px;
            font-weight:600;
            font-size:15px;
            margin-bottom:8px;
        ">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="18"
                 height="18"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="${color}"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>

            </svg>

            <span>${location.site_name}</span>

        </div>

        <div style="font-size:13px;line-height:1.7">
            <div><strong>Barangay:</strong> ${location.barangay}</div>
            <div><strong>Municipality:</strong> ${location.municipality?.name ?? '-'}</div>

            <div style="margin-top:10px;">
                <span style="
                    display:inline-block;
                    background:${color};
                    color:white;
                    padding:4px 10px;
                    border-radius:999px;
                    font-size:12px;
                    font-weight:600;
                ">
                    ${location.status?.name ?? 'No Status'}
                </span>
            </div>
        </div>

    </div>
`);
        // Current locations
        bounds.push(coordinates);

        // Store all locations
        allLocationsBounds.push(coordinates);
    });

    // Auto fit current locations
    if (bounds.length) {
        map.flyToBounds(bounds, {
            padding: [60, 60],
            duration: 1.2
        });
    }

    // Reset button
    const resetButton = document.querySelector('#resetMap');

    if (resetButton) {
        resetButton.addEventListener('click', () => {
            // Close popup
            map.closePopup();

            // Return to ALL locations
            if (allLocationsBounds.length) {
                map.flyToBounds(allLocationsBounds, {
                    padding: [60, 60],
                    duration: 1.2
                });
            } else {
                map.flyTo(defaultCenter, defaultZoom, {
                    animate: true,
                    duration: 1.2
                });
            }

            // Remove highlighted row
            document.querySelectorAll('[data-location-row]').forEach(row => {
                row.classList.remove(
                    'bg-violet-50',
                    'dark:bg-violet-950'
                );
            });
        });
    }

    // Focus marker
    window.focusMarker = function (id) {
        const marker = markers[id];

        if (!marker) return;

        document.querySelectorAll('[data-location-row]').forEach(row => {
            row.classList.remove(
                'bg-violet-50',
                'dark:bg-violet-950'
            );
        });

        const selectedRow = document.querySelector(
            `[data-location-row="${id}"]`
        );

        if (selectedRow) {
            selectedRow.classList.add(
                'bg-violet-50',
                'dark:bg-violet-950'
            );

            selectedRow.scrollIntoView({
                block: 'nearest',
                behavior: 'smooth'
            });
        }

        map.flyTo(
            marker.getLatLng(),
            16,
            {
                animate: true,
                duration: 1.2
            }
        );

        marker.openPopup();
    };
});