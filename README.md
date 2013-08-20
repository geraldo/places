Places: Template für Wordpress
==============================

`Places` is a theme for Wordpress. It's based on `_s`, or [`underscores`](http://underscores.me/).

The theme is ajax enabled and thought for mapping projects. It uses leaflet library to show locations on a OpenStreetMap and intends to stay always with the same map as background.

## Custom post type `place`

All registers of this post type are drawn by the template on the map. The only fields which have to be defined are `latitude` and `longitude`. The post type can easily be extended adding fields to `places_add_custom_box()` at `functions.php` and modifying template `content-single-place.php`.

## Page templates

- Home: Hides content window, typically used for home pages which directly want to show a map.
- Import Places: Imports a CSV file with format "id;title;latitude;longitude" into post type `place`.
- Export Places: Exports all registers of post type `place` to geojson file `places.tmp.js`. Leaflet uses file `places.js` so periodically (using a cron job or a Wordpress hook) exporting registers and copying the exported file over `places.js` updates the locations on the map.
- DataTables: Shows all registers of post type `place` as a [data table](http://www.datatables.net/).

## Install

1. Install wordpress theme as usual.
2. Move export folder to /wp-content/export.
3. Create content for custom post type `place`, or by importing with Import Places template or through Wordpress form.
4. Adapt all domains named geraldkogler.com to your domain and URLs containing `places` to your install directory.

## Included libraries

- [jQuery hashchange event v1.3](http://benalman.com/projects/jquery-hashchange-plugin/)
- [Leaflet v0.6](http://leafletjs.com/)
- [Leaflet.markercluster](https://github.com/Leaflet/Leaflet.markercluster)
- [Leaflet.Locate](https://github.com/domoritz/leaflet-locatecontrol)
- [DataTables v1.9.4](http://www.datatables.net/)

## License

`Places` is free software and uses a [GPL license](license.txt).
