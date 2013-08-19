var map, markers, markersArray;

function loadMap() {
	var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/60ec3a9d598e4c919b3ceda2344e0b19/94190/256/{z}/{x}/{y}.png',
		cloudmadeAttribution = '',
		cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
		latlng = new L.LatLng(48.30, 14.30);

	var icon = L.icon({
		iconUrl: '/wp/wp-content/themes/places/images/leaf-green.png',
		shadowUrl: '/wp/wp-content/themes/places/images/leaf-shadow.png',
		iconSize:     [38, 95], // size of the icon
		shadowSize:   [50, 64], // size of the shadow
		iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
		shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});

	map = new L.Map('map', {center: latlng, zoom: 13, layers: [cloudmade], attributionControl: false});
	markers = new L.MarkerClusterGroup({spiderfyDistanceMultiplier: 2.2, maxClusterRadius: 60, disableClusteringAtZoom: 18});
	markersArray = new Array();

	for (var i = 0; i < places.length; i++) {
		var a = places[i];
		var marker = new L.Marker(new L.LatLng(a[2], a[3]), { icon: icon});
		marker.bindPopup("<b>"+a[1]+"</b><br><!--id: ["+a[0]+"]--><br><br><a href='/wp/#/wp/place/"+a[4]+"'>Details anzeigen</a>").openPopup();
		markers.addLayer(marker);
		markersArray.push(marker);
	}
	map.addLayer(markers);

	L.control.locate({
		title: "Zeige mir meinen aktuellen Standpunkt",
		popupText: ["Du bist im Umkreis von ", " von diesem Punkt."],
	}).addTo(map);
}
