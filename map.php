<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    
    <title>Map at a specified location</title>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
  </head>
 
  </head>
  <?php
  include 'header.php';
  ?>
  <body>
  <div style="" id="map"></div>
  <script>
/*GLOBAL VARIABLES*/
let CLIENT_LOCATION;
let posContainer;
function moveMapToChampaign(map){
  map.setCenter({lat:40.116329, lng:-88.243523});
  map.setZoom(14);
}

var platform = new H.service.Platform({
  apikey: 'b6_Ha7aF8doVFHEDvZlK4XyE-u9kN_OtT6xacctqjTc'
});
var defaultLayers = platform.createDefaultLayers();

//Step 2: initialize a map - this map is centered over Europe
var map = new H.Map(document.getElementById('map'),
  defaultLayers.vector.normal.map,{
  center: {lat:50, lng:5},
  zoom: 4,
  pixelRatio: window.devicePixelRatio || 1
});
// add a resize listener to make sure that the map occupies the whole container
window.addEventListener('resize', () => map.getViewPort().resize());

//Step 3: make the map interactive
// MapEvents enables the event system
// Behavior implements default interactions for pan/zoom (also on mobile touch environments)
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

// Create the default UI components
var ui = H.ui.UI.createDefault(map, defaultLayers);

// Now use the map as required...
var geocoder = platform.getGeocodingService();

var group = new H.map.Group();

  map.addObject(group);

  // add 'tap' event listener, that opens info bubble, to the group
  group.addEventListener('tap', function (evt) {
    // event target is the marker itself, group is a parent event target
    // for all objects that it contains
    var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
      // read custom data
      content: evt.target.getData()
    });
    // show info bubble
    ui.addBubble(bubble);
  }, false);


      function handleLocationError(browserHasGeolocation, pos) {
        alert(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }

      function plotPoint(location, group, html){
        geocoder.geocode({searchText: location}, function(result) {
        let locations = result.Response.View[0].Result,
          position,
          marker;
        // Add a marker for each location found
        for (i = 0;  i < locations.length; i++) {
        position = {
          lat: locations[i].Location.DisplayPosition.Latitude,
          lng: locations[i].Location.DisplayPosition.Longitude
        };
        //marker = new H.map.Marker(position);
        //map.addObject(marker);
        addMarkerToGroup(group, position, html);
        }
      }, function(e) {
              console.log(e);
            });
      }
    let setPosition = function (position){
      posContainer = position;
    }

    function getPosition(){
      return posContainer;
    }
      function getDistanceToLocation(location, CLIENT_LOCATION, fn){
        let distance;
        let geo = geocoder.geocode({searchText: location}, function(result) {
        let locations = result.Response.View[0].Result,
          position,
          marker;
        // Add a marker for each location found
        for (i = 0;  i < locations.length; i++) {
        position = {
          lat: locations[i].Location.DisplayPosition.Latitude,
          lng: locations[i].Location.DisplayPosition.Longitude
        };
        
        }
        return getDistance(CLIENT_LOCATION, position);
      }, function(e) {
              console.log(e);
            });

        return geo;
      }


      let rad = function(x) {
      return x * Math.PI / 180;
    };


    let getDistance = function(p1, p2) {
      var R = 6378137; // Earth’s mean radius in meter
      var dLat = rad(p2.lat - p1.lat);
      var dLong = rad(p2.lng - p1.lng);
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(rad(p1.lat) * Math.cos(rad(p2.lat))) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c;
      return d/1609.344; // returns the distance in meter/mile
    };

function addMarkerToGroup(group, coordinate, html) {
  var marker = new H.map.Marker(coordinate);
  // add custom data to the marker
  marker.setData(html);
  group.addObject(marker);
}




window.onload = function () {
  moveMapToChampaign(map);
  if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            CLIENT_LOCATION = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            let icon = new H.map.Icon('person3.png');
            let marker = new H.map.Marker(CLIENT_LOCATION, { icon: icon });
            map.addObject(marker);
            map.setCenter(CLIENT_LOCATION);
            map.setZoom(14);

          }, function() {
            handleLocationError(true, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, map.getCenter());
        }

        let ourRequest = new XMLHttpRequest();
ourRequest.open('POST', "foodpantry.json");
ourRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
ourRequest.onload = function() {
  let myData = JSON.parse(ourRequest.responseText);
  myData.forEach(function(e){
    //let geo = getDistanceToLocation(e.address, CLIENT_LOCATION, setPosition);
    //console.log(geo);
    let phonenumberstring = "";
    e.phone.forEach(function(element){
      phonenumberstring += "<a href='tel:"+element.number+"' target='_blank'>"+element.number+"</a>"+element.type+"<BR>";
    });

    let emailstring = "";
    e.web.forEach(function(element){
      emailstring += (element.type=="website") ? "<a href='"+element.link+"' target='_blank'>"+element.link+"</a><BR>" : "<a href='mailto:"+element.link+"' target='_blank'>"+element.link+"</a><BR>";
    });
    let html = "<div style='width:400px;'><h1>"+e.name+"</h1><a href='https://www.google.com/maps/search/"+e.address+"/' target='_blank'>"+e.address+"</a><p>Hours: "+e.hours+"</p><p>Contact:<BR>"+phonenumberstring+emailstring+"</p></div>";
    plotPoint(e.address, group, html);
  })
}
ourRequest.send();

}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
  </script>
  </body>
</html>