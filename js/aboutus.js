function initMap() {
  // The location of Uluru
  var uluru = {lat: 1.377369, lng: 103.848874};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 18, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}

