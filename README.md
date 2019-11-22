Places: Wordpress Ajax Template
===============================

`Places` is a theme for Wordpress. It's based on `_s`, or [`underscores`](http://underscores.me/).

The theme is ajax enabled (heavy inspired by [AJAXify Wordpress Theme tutorial](https://deluxeblogtips.com/how-to-ajaxify-wordpress-theme/)) and thought for mapping projects. It uses leaflet library to show locations on a OpenStreetMap and intends to stay always with the same map as background.

## Custom post type `place`

All registers of this post type are drawn by the template on the map. The only fields which have to be defined are `latitude` and `longitude`. The post type can easily be extended adding fields to `places_add_custom_box()` at `functions.php` and modifying template `content-single-place.php`.

## Static or dynamic loading of locations

By default leaflet takes all registers of post type `place` through map.php and draws them on the map. To fasten up map loading, especially when having a lot of locations, it's recommandable to use static loading of places. It can be activated changing loading of `map.php` to `map.js`. To still get all actual locations on map you should use template Export Places as described in next section.

## Page templates

- **Home**: Hides content window, typically used for home pages which directly want to show a map.
- **Places JSON**: Outputs all nodes of content type `place` as JSON.
- **DataTables**: Shows all registers of post type `place` (from `Places JSON` file) as a [data table](http://www.datatables.net/).
- **Import Places**: Imports a CSV file with format "id;title;latitude;longitude" into post type `place`.
- **Export Places**: Exports all registers of post type `place` to geojson file `places.tmp.js`. Leaflet uses file `places.js` so periodically (using a cron job or a Wordpress hook) exporting registers and copying the exported file over `places.js` updates the locations on the map.

## Install

1. Install wordpress theme as usual.
2. Change initial zoom and center of map on line 19 and 20 in map.php.
3. Create content for custom post type `place`, or by importing with Import Places template or through Wordpress form.
4. Create pages based on templates `Places JSON`, `DataTables` and `Home`.
5. If you want an empty homepage (not showing the posts as default)you have to change Settings > Reading > Your homepage displays > A static page > Homepage > Home.

## Included libraries

- [jQuery hashchange event v1.3](http://benalman.com/projects/jquery-hashchange-plugin/)
- [Leaflet v1.6](http://leafletjs.com/)
- [DataTables v1.10.16](http://www.datatables.net/)

## License

`Places` is free software and uses a [GPL license](license.txt).
