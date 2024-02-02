<!DOCTYPE HTML>
<html>
<HEAD>
    <TITLE>BUS TIME</TITLE>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <LINK rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="">
    </script>

    <style>
        #map{height:350px;}
    </style>
</HEAD>
<body>
    <section id="header">
        <img src="image/logo.png" alt="image not found!" class="logo">
    </section>
    <section id="ctent">
        <div id="cont">
            <div id="map"></div>
        </div>
    </section>
    <section id="footer">
        <img src="image/logo.png" alt="image not found!" class="logo">
    </section>
</body>
<script>

    var map = L.map('map')
    

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    navigator.geolocation.watchPosition(success,error);
    function success(pos)
    {
        const lat=pos.coords.latitude;
        const lon=pos.coords.longitude;
        const accuracy = pos.coords.accuracy;

        L.marker([lat,lon]).addTo(map);
        L.circle([lat,lon],{radius: accuracy}).addTo(map);

        a=lat.toFixed(7);
        b=lon.toFixed(7);
        map.setView([lat, lon], 100);
    }

    function error(err)
    {
        if(err.code===1){
            alert("Please allow location access!");
        }
        else{
            alert("Cant access current location!")
        }
    }
    a=lat.toFixed(3);
    b=lon.toFixed(3);
    alert("lat:" + a + " Lon:" + b);
    map.setView([51.505, -0.09], 100);

</script> 
</html>