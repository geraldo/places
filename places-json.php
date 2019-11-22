<?php
/**
	Template Name: Places JSON
*/

header('Content-Type: application/json; charset=utf-8');
$fp = fopen('php://output', 'w');

/* get all places*/

$args = array(
	'post_type' => 'place',
	'post_status' => 'publish',
	'posts_per_page' => '1000',
	'order' => 'ASC',
	'orderby' => 'ID',
);

$my_query = new WP_Query($args);

if ( $my_query->have_posts() ) {

	$data = array();

	while ($my_query->have_posts()) {

		$my_query->the_post();

		$data[] = array(
			"id" => (int)get_the_ID(),
			"title" => html_entity_decode(get_the_title()),
			"description" => html_entity_decode(get_the_excerpt()),
			"lat" => (float)get_post_meta($id, '_places_lat', true),
			"lon" => (float)get_post_meta($id, '_places_long', true),
			"permalink" => get_permalink(get_the_ID()),
		);
	}

	echo json_encode(array("data" => $data));
}

fclose($fp);

?>