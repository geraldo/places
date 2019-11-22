/*
	based on Tutorial "How To AJAXify WordPress Theme"
	https://deluxeblogtips.com/how-to-ajaxify-wordpress-theme/
*/

jQuery(document).ready(function($) {
	$('#menu-top li').click(function() {
		$('#menu-top li').each(function() {
			$(this).removeClass('current-menu-item');
		});
		$(this).addClass('current-menu-item');
	});

    var $mainContent = $("#primary"),
    	siteUrl = top.location.protocol.toString() + "//" + top.location.host.toString(),
    url = '';

	$(document).on("click", "a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/wp-login.php']):not([href$='/feed/']):not([href*='/wp-content/uploads/']):not([href*='/wp-content/plugins/']):not([href*='/places-json/'])", function() {
		location.hash = this.pathname;
		return false;
	});

    $("#searchform").submit(function(e) {
		location.hash = '?s=' + $("#s").val();
		e.preventDefault();
    });

    $(window).bind('hashchange', function(){
		url = window.location.hash.substring(1);

		//exclude URLs from ajax behavior
		if (!url || 
			url.indexOf("comment")!= -1 ||
			url.indexOf("respond")!= -1 ||
			url.indexOf("json")!= -1) {
			return;
		}

		url = url + " #content";

		path = window.location.pathname.substring(1,window.location.pathname.length);
		path = window.location.pathname.substring(1,path.indexOf('/')+1);

		$mainContent.animate({opacity: "0.1"}).html('<img style="padding:20px;" src="'+window.location.protocol+"//"+window.location.host+'/'+path+'/wp-content/themes/places/images/ajax-loader.gif" />').load(url, function() {
			$mainContent.animate({opacity: "1"});

			//rebind javascript functions when loaded!
			//jQuery(document).ready() doesn't get triggered using AJAX

			//datatable
			if (url.indexOf("table")!= -1) {
				$('#primary').css('width','980');
				//load js
				$.getScript("https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js")
					.done(function(script, textStatus) {
						//console.log( textStatus );

						//apply data table
						$('#datatable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="places"></table>' );
						$('#places').DataTable( {
							paging: false,
							info: false,
							order: [[ 0, "asc" ]],
							responsible: true,
							search: true,
							stateSave: true,
							ajax: { url :"/"+path+"/index.php/places-json/", type : "GET"},
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
										return '<a class="abutton" href="/" onclick="map.setView(new L.LatLng('+row["lat"]+','+row["lon"]+'), 18, false);/*map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});*/">Show '+row["title"]+'</a>'; 
										}
								}
							]
						} );	

					})
					.fail(function(jqxhr, settings, exception) {
					//console.log( "Triggered ajaxError handler. "+exception );
				});
			}
			else {
				$('#primary').css('width','600');
			}
		});
    });
    $(window).trigger('hashchange');
});

