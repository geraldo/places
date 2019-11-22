<?php
/**
 * Template Name: Datatable
 *
 * @package places
 */

get_header(); ?>

	<div id="primary" class="content-area" style="width:980px;">
		<div id="content" class="site-content" role="main">
			<a class="close-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">×</a>

			<div class="entry-content">

				<!--<style type="text/css" title="currentStyle">
					@import "<?php echo get_stylesheet_directory_uri(); ?>/lib/demo_table.css";
				</style>
				<script type="text/javascript" language="javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/lib/jquery.dataTables.min.js"></script>
				<div id="datatable"></div>-->

				<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
				<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

				<div id="datatable"></div>

			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#datatable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="places"></table>' );
		$('#places').DataTable( {
			paging: false,
			info: false,
			order: [[ 0, "asc" ]],
			responsible: true,
			search: true,
			stateSave: true,
			ajax: { url :"<?php echo get_site_url(); ?>/index.php/places-json/", type : "GET"},
			columns: [
				{ "data": "title", "title": "Name", "render": function(data, type, row) {
						return "<a href='"+row["permalink"]+"'>"+data+"</a>"
					}
				},
				{ "data": "lat", "title": "lat", "searchable": false, "visible": false },
				{ "data": "lon", "title": "long", "searchable": false, "visible": false },
				{ "data": "description", "title": "description" },
				{ "searchable": false, "width": "75px", "sortable": false, "render": function(data, type, row) { 
						var id=row["title"]; 
						return '<a class="abutton" href="<?php echo esc_url( home_url( "/" ) ) ?>" onclick="map.setView(new L.LatLng('+row["lat"]+','+row["lon"]+'), 18, false);/*map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});*/">Show '+row["title"]+'</a>'; 
						}
				}
			]
		} );	
	});
</script>

<?php get_footer(); ?>
