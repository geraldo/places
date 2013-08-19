<?php
/**
	Template Name: Import Places
*/

$lines = file("http://localhost/wp/wp-content/export/places.csv");

foreach ($lines as $placesid => $line) {
	//start after header = line 0
	if ($placesid > 0) {
		$tokens = explode(';',$line);
		//$pid = trim($tokens[0]);
		$title = trim($tokens[1]);
		$lat = trim($tokens[2]);
		$long = trim($tokens[3]);

		//insert posts into wordpress
		$post = array(
			'post_author' => 1,				// usually admin
			'post_name' => $title,			// permalink
			'post_status' => 'publish',
			'post_title' => $title,
			'post_type' => 'place',
		);  

		//write to WP
		$id = wp_insert_post($post);
		//echo $title." SAVED WITH ID ".$id."<br>";

		//add meta data
		//add_post_meta($id, '_places_id', $placesid);
		add_post_meta($id, '_places_lat', $lat);
		add_post_meta($id, '_places_long', $long);
	}
}

?>
