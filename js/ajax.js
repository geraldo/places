/*
	based on Tutorial "How To AJAXify WordPress Theme"
	http://www.deluxeblogtips.com/2010/05/how-to-ajaxify-wordpress-theme.html
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
	$(document).on("click", "a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/wp-login.php']):not([href$='/feed/']):not([href*='/wp-content/uploads/']):not([href*='/wp-content/plugins/'])", function() {
		if ($.browser.msie && $.browser.version != 10.0) {
			var myie = "/" + this.pathname;
			location.hash = myie;
		}
		else {
			location.hash = this.pathname;
		}
		return false;
	});
    $("#searchform").submit(function(e) {
		location.hash = '?s=' + $("#s").val();
		e.preventDefault();
    });
    $(window).bind('hashchange', function(){
		url = window.location.hash.substring(1);
		//exclude URLs from ajax behavior
		if (!url || url.indexOf("comment")!= -1 || url.indexOf("respond")!= -1 || url.indexOf("wpcf7")!= -1) {
			return;
		}
		url = url + " #content";
		path = window.location.pathname.substring(1,window.location.pathname.length);
		path = window.location.pathname.substring(1,path.indexOf('/')+1);
		$mainContent.animate({opacity: "0.1"}).html('<img style="padding:20px;" src="'+window.location.protocol+"//"+window.location.host+'/'+path+'/wp-content/themes/places/images/ajax-loader.gif" />').load(url, function() {
			$mainContent.animate({opacity: "1"});

			//rebind javascript functions when loaded!
			//jQuery(document).ready() doesn't get triggered using AJAX

			//blog
			if (url.indexOf("blog")!= -1) {
				$("p").each(function() {
					$(this).css('margin-bottom','20px');
				});
			}

			//datatable
			if (url.indexOf("table")!= -1) {
				$('#primary').css('width','980');
				//load js
				$.getScript(window.location.protocol+"//"+window.location.host+"/wp/wp-content/themes/places/lib/jquery.dataTables.min.js")
					.done(function(script, textStatus) {
						//console.log( textStatus );

						//apply data table
						$('#datatable').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="places"></table>' );
						$('#places').dataTable( {
							"aaData": places,
							"aoColumns": [
								{ "sTitle": "#" },
								{ "sTitle": "Name" },
								{ "sTitle": "lat", "bSearchable": false, "bVisible": false },
								{ "sTitle": "long", "bSearchable": false, "bVisible": false },
								{ "bSearchable": false, "sWidth": "75px", "bSortable": false, "fnRender": function(oObj) { var id=oObj.aData[0]-1; return '<a class="abutton" href="'+window.location.protocol+"//"+window.location.host+'" onclick="map.setView(new L.LatLng('+oObj.aData[2]+','+oObj.aData[3]+'), 18, false);map.on(\'zoomend\', function(e) {markersArray['+id+'].openPopup()});">Show #'+oObj.aData[0]+'</a>'; } }
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

