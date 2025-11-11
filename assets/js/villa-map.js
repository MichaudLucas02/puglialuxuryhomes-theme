(function () {
  function initMap(el) {
    var lat = parseFloat(el.dataset.lat);
    var lng = parseFloat(el.dataset.lng);
    if (isNaN(lat) || isNaN(lng)) return;

    var map = L.map(el, { scrollWheelZoom: false });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);
    if (el.dataset.popup) marker.bindPopup(el.dataset.popup);

    map.setView([lat, lng], 14);

    // If the map is in a hidden accordion, reflow on open
    var panel = el.closest('.acc-panel');
    if (panel) {
      var btnId = panel.getAttribute('aria-labelledby');
      var btn = btnId ? document.getElementById(btnId) : null;
      if (btn) {
        btn.addEventListener('click', function () {
          setTimeout(function () { map.invalidateSize(); }, 250);
        });
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.villa-map').forEach(initMap);
  });
})();
