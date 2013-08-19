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

				<style type="text/css" title="currentStyle">
					@import "<?php echo get_stylesheet_directory_uri(); ?>/lib/demo_table.css";
				</style>
				<script type="text/javascript" language="javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/lib/jquery.dataTables.min.js"></script>
				<div id="datatable"></div>

			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#datatable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="places"></table>' );
		$('#places').dataTable( {
			"aaData": places,
			"aoColumns": [
				{ "sTitle": "#" },
				{ "sTitle": "Name" },
				{ "sTitle": "lat", "bSearchable": false, "bVisible": false },
				{ "sTitle": "long", "bSearchable": false, "bVisible": false },
				{ "bSearchable": false, "sWidth": "75px", "bSortable": false, "fnRender": function(oObj) { var id=oObj.aData[0]-1; return '<a class="abutton" href="<?php echo esc_url( home_url( "/" ) ) ?>" onclick="map.setView(new L.LatLng('+oObj.aData[2]+','+oObj.aData[3]+'), 18, false);map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});">Show #'+oObj.aData[0]+'</a>'; } }
			],
			"oLanguage": {
						"sLengthMenu": "Show _MENU_ registers on page",
						"sZeroRecords": "Nothing found - sorry",
						"sInfo": "Show _START_ to _END_ out of _TOTAL_ registers",
						"sInfoEmpty": "Show 0 to 0 out of 0 registers",
						"sInfoFiltered": "(filtered out of _MAX_ registers)",
						"sSearch" : "Search:",
						"oPaginate": {
								"sPrevious": "Previous page",
								"sNext": "Next page",
								"sFirst": "First page",
								"sLast": "Last page"
							  }
					},
			"aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
			"iDisplayLength": 20,
			"aaSorting": [[ 0, "asc" ]],
			"sPaginationType": "full_numbers",
			"bAutoWidth": false
		} );	
	});
</script>

<?php get_footer(); ?>
