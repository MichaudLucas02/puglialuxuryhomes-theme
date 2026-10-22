/* Homepage "Where in Puglia" map.
   Same look as the map on the villas listing page (all-villas.php):
   Leaflet + Stadia "alidade smooth" tiles, dot markers, photo popups.
   Region buttons zoom the map to that region's villas. */
(function () {
  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function makeIcon(active) {
    return L.divIcon({
      className: 'plh-marker' + (active ? ' plh-marker--active' : ''),
      html: '<div class="plh-marker__dot"></div>',
      iconSize: [12, 12],
      iconAnchor: [6, 6],
      popupAnchor: [0, -12]
    });
  }

  function popupHtml(v, ctaLabel) {
    return '<div class="plh-popup">' +
      (v.image ? '<img src="' + escapeHtml(v.image) + '" class="plh-popup__img" alt="' + escapeHtml(v.title) + '">' : '') +
      '<div class="plh-popup__body">' +
        '<p class="plh-popup__title">' + escapeHtml(v.title) + '</p>' +
        (v.meta ? '<p class="plh-popup__meta">' + escapeHtml(v.meta) + '</p>' : '') +
        (v.price ? '<p class="plh-popup__price">' + escapeHtml(v.price) + '</p>' : '') +
        '<a href="' + escapeHtml(v.url) + '" class="plh-popup__btn">' + escapeHtml(ctaLabel) + '</a>' +
      '</div>' +
    '</div>';
  }

  function initMap(el) {
    var data;
    try { data = JSON.parse(el.dataset.map || '{}'); } catch (e) { return; }
    var villas = data.villas || [];
    if (!villas.length) return;

    var ctaLabel = (data.labels && data.labels.cta) || 'Discover the villa';

    // Scroll-wheel zoom off so the page scrolls normally past the map
    var map = L.map(el, { zoomControl: true, scrollWheelZoom: false });
    map.attributionControl.setPrefix(false);

    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
      attribution: '',
      maxZoom: 20
    }).addTo(map);

    var markers = villas.map(function (v) {
      var marker = L.marker([v.lat, v.lng], { icon: makeIcon(false) });
      marker.bindPopup(popupHtml(v, ctaLabel), { maxWidth: 280 });
      marker.on('mouseover', function () { marker.setIcon(makeIcon(true)); });
      marker.on('mouseout', function () { if (!marker.isPopupOpen()) marker.setIcon(makeIcon(false)); });
      marker.on('popupopen', function () { marker.setIcon(makeIcon(true)); });
      marker.on('popupclose', function () { marker.setIcon(makeIcon(false)); });
      marker.addTo(map);
      marker._region = v.region;
      return marker;
    });

    function boundsFor(list) {
      return L.latLngBounds(list.map(function (m) { return m.getLatLng(); }));
    }

    var active = null;

    function showAll() { map.fitBounds(boundsFor(markers), { padding: [40, 40] }); }

    function showRegion(region) {
      var list = markers.filter(function (m) { return m._region === region; });
      if (!list.length) return false;
      if (list.length === 1) map.setView(list[0].getLatLng(), 12);
      else map.fitBounds(boundsFor(list), { padding: [50, 50] });
      return true;
    }

    showAll();

    // Keep the current view framed when the section is resized
    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        map.invalidateSize();
        active ? showRegion(active) : showAll();
      }, 200);
    });

    // Region buttons: zoom to that region; clicking the active one again shows everything
    var section = el.closest('.where-puglia');
    var buttons = section ? section.querySelectorAll('.where-region-btn') : [];

    Array.prototype.forEach.call(buttons, function (btn) {
      btn.setAttribute('aria-pressed', 'false');
      btn.addEventListener('click', function () {
        var region = btn.dataset.region;
        map.closePopup();

        Array.prototype.forEach.call(buttons, function (b) {
          b.setAttribute('aria-pressed', 'false');
          b.closest('.where-region').classList.remove('is-active');
        });

        if (active === region) {
          active = null;
          showAll();
          return;
        }

        if (!showRegion(region)) return;
        active = region;
        btn.setAttribute('aria-pressed', 'true');
        btn.closest('.where-region').classList.add('is-active');
      });
    });
  }

  function initAll() {
    if (typeof L === 'undefined') return;
    document.querySelectorAll('.where-map').forEach(initMap);
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initAll);
  else initAll();
})();
