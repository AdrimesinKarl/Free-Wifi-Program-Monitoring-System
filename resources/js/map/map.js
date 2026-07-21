document.addEventListener('DOMContentLoaded', () => {

    const mapElement = document.querySelector('#map');

    if (!mapElement) return;

    // ---------------------------
    // Initialize Map
    // ---------------------------

    const map = L.map('map', {
        zoomControl: true
    }).setView([11.0, 122.5], 8);

    L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap contributors'
    }
).addTo(map);

    // ---------------------------
    // Get Locations
    // ---------------------------

    const locations = JSON.parse(
        mapElement.dataset.locations || '[]'
    );

    const bounds = [];
    const markers = {};

    // ---------------------------
    // Marker Creation
    // ---------------------------

    locations.forEach(location => {

        if (!location.latitude || !location.longitude) return;

        const color = location.status?.color ?? '#64748b';

        const marker = L.circleMarker(
            [
                Number(location.latitude),
                Number(location.longitude)
            ],
            {
                radius: 9,
                weight: 3,
                color: '#ffffff',
                fillColor: color,
                fillOpacity: 1
            }
        ).addTo(map);

        markers[location.id] = marker;

        marker.bindPopup(`
            <div style="min-width:240px">

                <div style="font-weight:600;font-size:15px;margin-bottom:8px;">
                    📍 ${location.site_name}
                </div>

                <div style="font-size:13px;line-height:1.7">

                    <div>
                        <strong>Barangay:</strong>
                        ${location.barangay}
                    </div>

                    <div>
                        <strong>Municipality:</strong>
                        ${location.municipality?.name ?? '-'}
                    </div>

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

        bounds.push([
            Number(location.latitude),
            Number(location.longitude)
        ]);

    });

    // ---------------------------
    // Auto Fit
    // ---------------------------

    if (bounds.length) {

        map.fitBounds(bounds, {
            padding: [40, 40]
        });

    }

    // ---------------------------
    // Reset View Button
    // ---------------------------

    const resetButton = document.querySelector('#resetMap');

    if (resetButton) {

        resetButton.addEventListener('click', () => {

            if (bounds.length) {

                map.fitBounds(bounds, {
                    padding: [40, 40]
                });

            }

            document
                .querySelectorAll('[data-location-row]')
                .forEach(row => {
                    row.classList.remove(
                        'bg-violet-50',
                        'dark:bg-violet-950'
                    );
                });

        });

    }

    // ---------------------------
    // Focus Marker
    // ---------------------------

    window.focusMarker = function (id) {

        const marker = markers[id];

        if (!marker) return;

        // Highlight selected row
        document
            .querySelectorAll('[data-location-row]')
            .forEach(row => {

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

        // Animate map
        map.flyTo(
            marker.getLatLng(),
            16,
            {
                animate: true,
                duration: 1.2
            }
        );

        // Temporary marker animation
        marker.setStyle({
            radius: 13
        });

        setTimeout(() => {

            marker.setStyle({
                radius: 9
            });

        }, 600);

        marker.openPopup();

    };

});