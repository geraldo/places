Places: Template für Wordpress
==============================

Places is a theme for Wordpress. It's based on `_s`, or [`underscores`](http://underscores.me/).

The theme is ajax enabled and thought for mapping projects. It uses leaflet library to show custom type places on a OpenStreetMap and intends to stay always with the same map as background.

## Custom content type "place"

All registers of this content type are drawn by the template on the map. The only fields which have to defined are latitude and longitude.

## Page templates

Home: Hides content window, typically used for home pages which directly want to show a map.
Import Places: Imports a CSV file with format "id,title,latitude,longitude" into content type "place".
Export Places: Exports all registers of content type "place" to geojson file places.tmp.js which is used by leaflet.
DataTables: Shows all registers of content type "place" as a [data table](http://www.datatables.net/).

## Included libraries

[jQuery hashchange event v1.3](http://benalman.com/projects/jquery-hashchange-plugin/)
[Leaflet v0.6](http://leafletjs.com/)
[Leaflet.markercluster](https://github.com/Leaflet/Leaflet.markercluster)
[Leaflet.Locate](https://github.com/domoritz/leaflet-locatecontrol)
[DataTables v1.9.4](http://www.datatables.net/)

## License

places is free software and uses a [GPL license](license.txt).
