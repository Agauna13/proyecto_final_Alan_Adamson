/**
 * Fuente y autor https://leafletjs.com/examples/quick-start/ para el mapa de
 * la landing
 */


document.addEventListener('DOMContentLoaded', function () {
    var lat = 39.58043222712172;
    var lng = 2.6764944692251316;
    var zoom = 18;

    var map = L.map('map').setView([lat, lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 21,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Contenido HTML del popup con enlace
    var popupContent = `
            <strong>¡Estamos aquí!</strong><br>
            <a href="https://www.google.com/maps/place/Hamburgueseria+Mokitrokis/@39.5803513,2.6765649,21z/data=!4m6!3m5!1s0x1297930a859b2747:0x18b7540b74a6bc18!8m2!3d39.5804225!4d2.676496!16s%2Fg%2F11bxfjrn0m?entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D"
                target="_blank"
                class="text-indigo-600 hover:underline">
                Ver en Google Maps
            </a>
        `;

    L.marker([lat, lng]).addTo(map)
        .bindPopup(popupContent)
        .openPopup();
});
