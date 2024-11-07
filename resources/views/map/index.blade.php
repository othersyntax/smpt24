<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Map</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
          'packages':['geochart']
        });
        google.charts.setOnLoadCallback(drawRegionsMap);
  
        function drawRegionsMap() {
          var data = google.visualization.arrayToDataTable([
            ['State', 'Select'],
            ['MY-16', 125],
            ['MY-15', 158],
            ['MY-14', 149],
            ['MY-13', 230],
            ['MY-12', 400],
            ['MY-11', 120],
            ['MY-10', 156],
            ['MY-09', 170],
            ['MY-08', 209],
            ['MY-07', 230],
            ['MY-06', 400],
            ['MY-05', 156],
            ['MY-04', 156],
            ['MY-03', 170],
            ['MY-02', 231],
            ['MY-01', 230],
          ]);
  
          var options = {
            region: 'MY',
            displayMode: 'regions',
            resolution: 'provinces',
            colorAxis: {colors: ['white', 'purple']},
            height: 600,
            width: 800,
          };
  
          var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
  
          chart.draw(data, options);
        }
    </script>
  
    <style>
        /* 
        * Always set the map height explicitly to define the size of the div element
        * that contains the map. 
        */
        #map {
        height: 100%;
        }

        /* 
        * Optional: Makes the sample page fill the window. 
        */
        html,
        body {
        height: 100%;
        margin: 0;
        padding: 0;
        }

    </style>
</head>
<body>
    <div id="regions_div"></div>

    <div id="map"></div>

    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAuKZQOP7epg3C34hYdDLwNpJXMECXIR34&callback=initMap">
    </script>
    <script>
        let map;

        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            const uluru = { lat: 2.9182226, lng: 101.7051225 };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 18,
                center: uluru,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
                title: "Rumah Usup",
            });
        }

        window.initMap = initMap;
    </script>
</body>

</html>