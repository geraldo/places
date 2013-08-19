<?php
/**
	Template Name: Export Places
*/

$url = '/var/www/places/wp-content/export/places.tmp.js';

//$foutput = (file_exists($url)) ? fopen($url, "w") : fopen($url, "w+");
$foutput = fopen($url, "w");
fwrite($foutput, 'var places = ['.PHP_EOL);

//total amount: wp_count_posts('place')->publish = 1

writeJS($foutput);

//stop to write geojson file
fwrite($foutput, '];'.PHP_EOL);
fclose($foutput);

function writeJS($foutput) {

	$my_query = new WP_Query('post_type=place&order=ASC&orderby=ID');

	if ( have_posts() ) {

		$n = 1;

		while ($my_query->have_posts()) {

			$my_query->the_post();

			//$id = get_post_meta(get_the_ID(), 'baumid', true);
			$titel = get_the_title();
			$lat = get_post_meta(get_the_ID(), '_places_lat', true);
			$long = get_post_meta(get_the_ID(), '_places_long', true);
			$linkurl = get_permalink(get_the_ID());
//echo $linkurl;
			$tokens = explode('/',$linkurl);
echo $tokens[count($tokens)-2];
			$link = $tokens[count($tokens)-2];
echo $link;

			fwrite($foutput, "[".$n.", '".$titel."', ".$lat.", ".$long.", '".$link."', ''],".PHP_EOL);	

			$n++;
		}
		echo $n." datasets written to json file ".$url."<br>";
	}
}
?>
