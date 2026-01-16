(function () {
  function initMap(el) {
    var lat = parseFloat(el.dataset.lat);
    var lng = parseFloat(el.dataset.lng);
    if (isNaN(lat) || isNaN(lng)) return;

    var position = { lat: lat, lng: lng };

    // Create the map
    var map = new google.maps.Map(el, {
      center: position,
      zoom: 14,
      scrollwheel: false,
      gestureHandling: 'cooperative',
      mapTypeControl: true,
      streetViewControl: false,
      fullscreenControl: true,
      styles: [
        {
          featureType: 'poi',
          elementType: 'labels',
          stylers: [{ visibility: 'off' }]
        }
      ]
    });

    // Create the marker
    var marker = new google.maps.Marker({
      position: position,
      map: map,
      title: el.dataset.popup || ''
    });

    // Add info window if popup text exists
    if (el.dataset.popup) {
      var infoWindow = new google.maps.InfoWindow({
        content: '<div style="padding:8px;font-family:Raleway,sans-serif;">' + el.dataset.popup + '</div>'
      });
      
      marker.addListener('click', function() {
        infoWindow.open(map, marker);
      });
    }

    // If the map is in a hidden accordion, trigger resize on open
    var panel = el.closest('.acc-panel');
    if (panel) {
      var btnId = panel.getAttribute('aria-labelledby');
      var btn = btnId ? document.getElementById(btnId) : null;
      if (btn) {
        btn.addEventListener('click', function () {
          setTimeout(function () {
            google.maps.event.trigger(map, 'resize');
            map.setCenter(position);
          }, 250);
        });
      }
    }
  }

  // Wait for Google Maps API to load
  function initAllMaps() {
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
      setTimeout(initAllMaps, 100);
      return;
    }
    document.querySelectorAll('.villa-map').forEach(initMap);
  }

  document.addEventListener('DOMContentLoaded', initAllMaps);
})();
