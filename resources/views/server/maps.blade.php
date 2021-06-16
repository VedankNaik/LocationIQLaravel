<!DOCTYPE html>
<html ng-app="MapboxModule">
<!--pk.eyJ1IjoidmVkMDEiLCJhIjoiY2twOXVzNDdpMG1lNzJyb2dxcmxibnFubSJ9.6oODJ37lFikEEG2Av_P_6w-->
<head>
    <meta charset="utf-8"/>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
    <link href="mapcss.css" rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('css/map.css') }}">

    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">

    <!-- Promise polyfill script is required -->
    <!-- to use Mapbox GL Geocoder in IE 11. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
    
</head>
<body>   
    <div id='map'></div>
    <div id="menu">
        <input id="satellite-v9" type="radio" name="rtoggle" value="satellite" checked="checked">
        <label for="satellite-v9">satellite</label>
        <input id="light-v10" type="radio" name="rtoggle" value="light">
        <label for="light-v10">light</label>
        <input id="dark-v10" type="radio" name="rtoggle" value="dark">
        <label for="dark-v10">dark</label>
        <input id="streets-v11" type="radio" name="rtoggle" value="streets">
        <label for="streets-v11">streets</label>
        <input id="outdoors-v11" type="radio" name="rtoggle" value="outdoors">
        <label for="outdoors-v11">outdoors</label>
    </div>
</body>

<style>
body { margin: 0; padding: 0; }

#map { position: absolute; top: 0; bottom: 0; width: 100%; }

#menu {
position: absolute;
background: #efefef;
padding: 10px;
font-family: 'Open Sans', sans-serif;
}

.calculation-box {
height: 75px;
width: 150px;
position: absolute;
bottom: 40px;
left: 10px;
background-color: rgba(255, 255, 255, 0.9);
padding: 15px;
text-align: center;
}
 
p {
font-family: 'Open Sans';
margin: 0;
font-size: 13px;
}
</style>


<script>
   // Map setup
   mapboxgl.accessToken = 'pk.eyJ1IjoidmVkMDEiLCJhIjoiY2twOXVzNDdpMG1lNzJyb2dxcmxibnFubSJ9.6oODJ37lFikEEG2Av_P_6w';
    var map = new mapboxgl.Map({
      container: 'map',
      zoom: 15.5,
      center: [-74.0066, 40.7135],
      style: 'mapbox://styles/mapbox/streets-v11',
      pitch: 45,
    //   bearing: -17.6,
      antialias: true
    });
    
    

    // Add the Geocoder to the map.
    map.addControl(
    new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    mapboxgl: mapboxgl
    }), 'top-right'
    );

    map.addControl(new MapboxDirections({accessToken: mapboxgl.accessToken}),'bottom-right');
    map.addControl(new mapboxgl.NavigationControl());
    

    // Add controls for layers
    var layerList = document.getElementById('menu');
    var inputs = layerList.getElementsByTagName('input');
    
    function switchLayer(layer) {
    var layerId = layer.target.id;
    map.setStyle('mapbox://styles/mapbox/' + layerId);
    }
    
    for (var i = 0; i < inputs.length; i++) {
    inputs[i].onclick = switchLayer;
    }

    map.on('load', function () {
    // Insert the layer beneath any symbol layer.
    var layers = map.getStyle().layers;
    var labelLayerId;
    for (var i = 0; i < layers.length; i++) {
    if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
    labelLayerId = layers[i].id;
    break;
    }
    }
    
    // The 'building' layer in the Mapbox Streets
    // vector tileset contains building height data
    // from OpenStreetMap.
    map.addLayer(
    {
    'id': 'add-3d-buildings',
    'source': 'composite',
    'source-layer': 'building',
    'filter': ['==', 'extrude', 'true'],
    'type': 'fill-extrusion',
    'minzoom': 15,
    'paint': {
    'fill-extrusion-color': '#aaa',
    
    // Use an 'interpolate' expression to
    // add a smooth transition effect to
    // the buildings as the user zooms in.
    'fill-extrusion-height': [
    'interpolate',
    ['linear'],
    ['zoom'],
    15,
    0,
    15.05,
    ['get', 'height']
    ],
    'fill-extrusion-base': [
    'interpolate',
    ['linear'],
    ['zoom'],
    15,
    0,
    15.05,
    ['get', 'min_height']
    ],
    'fill-extrusion-opacity': 0.6
    }
    },
    
    labelLayerId
    );
    });

    
</script>

</html>