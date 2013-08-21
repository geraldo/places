<?php
	//Let's set the header straight
	header('Content-type: text/javascript');

	//Get the WP-specifics, so that we can use constants and what not
	$home_dir = preg_replace('^wp-content/themes/[a-z0-9\-/]+^', '', getcwd());
	include($home_dir . 'wp-load.php');
?>

var map, markers, markersArray;

function loadMap() {
	var cloudmadeUrl = 'http://{s}.tile.cloudmade.com/60ec3a9d598e4c919b3ceda2344e0b19/94190/256/{z}/{x}/{y}.png',
		cloudmadeAttribution = '',
		cloudmade = new L.TileLayer(cloudmadeUrl, {maxZoom: 18, attribution: cloudmadeAttribution}),
		latlng = new L.LatLng(48.30, 14.30);

	var icon = L.icon({
		iconUrl: '/places/wp-content/themes/places/images/leaf-green.png',
		shadowUrl: '/places/wp-content/themes/places/images/leaf-shadow.png',
		iconSize:     [38, 95], // size of the icon
		shadowSize:   [50, 64], // size of the shadow
		iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
		shadowAnchor: [4, 62],  // the same for the shadow
		popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
	});

	map = new L.Map('map', {center: latlng, zoom: 13, layers: [cloudmade], attributionControl: false});
	markers = new L.MarkerClusterGroup({spiderfyDistanceMultiplier: 2.2, maxClusterRadius: 60, disableClusteringAtZoom: 18});
	markersArray = new Array();

<?php
	$ids = 'var ids=[';
	$titles = 'var titles=[';
	$lats = 'var lats=[';
	$longs = 'var longs=[';
	$links = 'var links=[';

	$my_query = new WP_Query('post_type=place&order=ASC&orderby=ID');

	if ( $my_query->have_posts() ) {

		$n = 1;

		while ($my_query->have_posts()) {

			$my_query->the_post();

			//$id = get_post_meta(get_the_ID(), 'placeid', true);
			$id = get_the_ID();
			if ($n>1) {
				$ids .= ',';
				$titles .= ',';
				$lats .= ',';
				$longs .= ',';
				$links .= ',';
			}
			$ids .= $n;
			$titles .= '"'.get_the_title().'"';
			$lats .= get_post_meta($id, '_places_lat', true);
			$longs .= get_post_meta($id, '_places_long', true);
			$links .= '"'.get_permalink($id).'"';

			$n++;
		}
	}
	$ids .= "];";
	$titles .= "];";
	$lats .= "];";
	$longs .= "];";
	$links .= "];";

	echo "\t".$ids.PHP_EOL;
	echo "\t".$titles.PHP_EOL;
	echo "\t".$lats.PHP_EOL;
	echo "\t".$longs.PHP_EOL;
	echo "\t".$links.PHP_EOL;
?>

	for (var i = 0; i < ids.length; i++) {
		var marker = new L.Marker(new L.LatLng(lats[i], longs[i]), { icon: icon});
		marker.bindPopup("<b>"+titles[i]+"</b><br><!--id: ["+ids[i]+"]--><br><br><a href='/places/#/places/place/"+links[i]+"'>Details anzeigen</a>").openPopup();
		markers.addLayer(marker);
		markersArray.push(marker);
	}

	map.addLayer(markers);

	L.control.locate({
		title: "Show me my position",
		popupText: ["You are in a radius of ", " from this point."],
	}).addTo(map);
}
