<!DOCTYPE HTML>
<html lang="en">
<HEAD>
    <TITLE>BUS TIME</TITLE>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <LINK rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik+Doodle+Shadow&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    
    <script 
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="">
    </script>

    <style>
        #map{
            text-align: center;
            margin-block: 20px;
            padding-block: 20px;
            height: 500px;
            width: 97%;
            z-index: 0;
            margin:auto;
        }
    </style>
</HEAD>
<body onload="getlocation()">
    <section id="page">
        <section id="header">
            <a href="Home.html"><img src="image\logo bgr.png" alt="image not found!" class="logo"></a>
        </section>
        <section id="ctent">
            <div id="cont">
                <div style="text-align: right;padding-right: 35px;">
                    <button style="z-index: 3;
                            border: 1px;
                            text-decoration: none;
                            font-family: 'Noto Sans', sans-serif;
                            font-size: 10px;
                            position: fixed;
                            width: 100;
                            border-radius: 4px;
                            text-decoration: none;
                            display: inline-block;
                            margin: 10px;
                            padding: 12px ;
                            color: rgb(255, 255, 255);
                            border: 0.1px solid rgb(255, 255, 255);
                            background: transparent;
                            position: relative;
                            z-index: 1;
                            transition: color 0.1s linear;" 
                    onclick="view()"><span></span>Reset View</a>
                </div>
                <div id="mapsec"><div id="map"></div></div>
            </div>
        </section>
        <section id="ctent">
            <div class="btn" id="finder"><a href="#mapsec" onclick="getbusstops()" class="add"><span></span>Find nearest Bus Stop</a></div>
            <div class="newel" id="sec"></div>
        </section>
        <section id="footer"></section>
        <div id="sidenav" style="right:-250px;">
            <nav>
                <ul>
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="tickets.html">My tickets</a></li>
                    <li><a href="dashboard.php">Contribute</a></li>
                    <li><a href="#complaints">Complaints</a></li>
                    <li><a href="#complaints">Contact us</a></li>
                </ul>
            </nav>
            <div class="btn">
                <form action="busstop.php" method="post">
                    <input type="hidden" id="lati" name="lati">
                    <input type="hidden" id="long" name="long">
                    <input type="hidden" id="emp">
                    <button style="width: 200px;position:relative;top: 200px;">DATABASE - PHP</button>
                </form>
                <form action="bustime.php" method="post"> <!--to time-->
                    <input type="hidden" id="ses" name="sessid">
                    <input type="hidden" id="sesname" name="sessname">
                    <input type="hidden" name="cm" id="cm">
                    <button style="width: 200px;position:relative;top: 200px;display:none" id="subm" name="subm">Bus Time</button>
                </form>
            </div>
        </div>
        <div id="menubtn">
            <img src="image/menu.png" alt="image not found!" id="menu">
        </div>
        <script>
            var menubtn = document.getElementById("menubtn")
            var menubtn = document.getElementById("sidenav")
            var menubtn = document.getElementById("menu")

            menubtn.onclick = function(){
                if(sidenav.style.right=="-250px")
                {
                    sidenav.style.right="0px";
                }
                else
                {
                    sidenav.style.right="-250px";
                }
            }
        </script>
        <div class="btn">
            <div id="complaints" style="font-family:'Noto Sans', sans-serif;color:white;text-align:left;padding-top:150px;padding-left:15px;padding-bottom:50px"><br>
                <hr style="color:red;size:3px;width:98%;margin:auto"><br><br>
                <h1 style="font-size:40px;font-family:'Noto Sans', sans-serif;color:red;">Complaints</h1><br>
                <form action="#">
                    <input style="font-size:20px;padding:20px;width:400px;margin-bottom:40px;" type="text" id="nam" name="nam" placeholder=" Your name" required><br><br>
                    <br><input style="font-size:20px;padding:20px;width:400px;margin-bottom:40px;" type="email" id="mail" name="mail" placeholder=" Your email id" required><br><br>
                    <br><input style="font-size:20px;padding:20px;height:300px;width:400px;" style="height:50px;width:100px" type="textarea" name="compl" id="compl" required placeholder=" Describe Your problem">
                    <br><br><button id="comp" style="height:50px;width:100px;padding-left:15px;margin-left:340px;cursor:pointer"><span></span>Submit</button>
                </form>
            </div>
        </div>
    </section>
</body>
<script>
    setInterval(getlocation(),1000);
    function view(){
        map.setView([lat, lon],100);
    }
    var cou=1;
    function getlocation()
    {
        if(cou==1)
        {
            getbusstops();
            cou++;
        }
        document.getElementById("map").style.display="block";

        globalThis.map = L.map('map')

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        navigator.geolocation.watchPosition(success,error); //locating user
        function success(pos)
        {
            globalThis.lat=pos.coords.latitude;
            globalThis.lon=pos.coords.longitude;
            globalThis.accuracy = pos.coords.accuracy;

            var xhr = new XMLHttpRequest();
            var url = "busstop.php";
            var params = "lati=" + lat + "&long=" + lon;
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send(params);

            //alert(params);

            if(document.getElementById("lati").value!='')
            {
                //alert(document.getElementById("lati").value)
                var latit=document.getElementById("lati").value;
                var longit=document.getElementById("long").value;
                map.removeLayer(L.circleMarker([latit,longit]).addTo(map))
                setInterval(success(),1000);
            }

            var cm=L.circleMarker([lat,lon],{
                radius: 10,
                stroke: true,
                color: 'red',
                opacity: 1,
                weight: 1,
                fill: true,
                fillColor: "blue",
                fillOpacity:0.5,
            }).addTo(map);
            cm.bindPopup("You",{autoClose:false, autoPan:false}).openPopup();

            map.setView([lat, lon], 100);
            document.getElementById("long").value=lon;
            document.getElementById("lati").value=lat;
            document.getElementById("cm").value=params;
        }

        function error(err)
        {
            if(err.code===1){
                alert("Please allow location access!");
            }
            else{
                alert("Cant access location!")
            }
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function getbusstops() 
    {
        fetch("stops.json") //JSONpart
            .then(res => res.json())
            .then(data => {
                    const busStopsArray = [];
                    data.forEach(stop => 
                    {
                        const stopArray = [
                            stop.SerialNo,
                            stop.Stopname,
                            stop.Latitude,
                            stop.Longitude,
                            stop.PostalCode,
                            stop.Distance
                        ];

                        busStopsArray.push(stopArray);
                        console.log(busStopsArray);
                    })

                    const addBtn = document.querySelector(".add");
                    const input = document.querySelector(".newel");

                    addBtn.addEventListener("click", addInput);

                    function addInput()
                    { 
                        globalThis.flex = document.createElement("div");
                        flex.className = "btn";
                        const arr=new Array;
                        var itr=0;
                        busStopsArray.forEach(stop => 
                        {
                            arr[itr]={
                                ids:stop[0],
                                Name:stop[1],
                                Latitude:stop[2],
                                Longitude:stop[3],
                                Postalcode:stop[4],
                                Distance:stop[5]
                            }

                            console.log(arr[itr]);

                            document.getElementById("finder").style.display = "none";
                            const newelement = document.createElement("a");
                            newelement.style.cursor="pointer";
                            newelement.id=arr[itr].ids+") "+stop[1];
                            //alert(newelement.id);
                            //alert(arr[itr].ids);

                            newelement.addEventListener("click",function()
                            {
                                document.getElementById("ses").value=newelement.id;
                                //if(confirm(newelement.id))
                                {
                                    document.getElementById("subm").click();
                                }
                            });
                            const t = document.createTextNode(arr[itr].Name+": "+(arr[itr].Distance*1000).toFixed(1)+"m");
                            const span=document.createElement("span");
                            newelement.appendChild(span);
                            newelement.appendChild(t);

                            input.appendChild(flex);
                            flex.appendChild(newelement);

                            //alert(arr[itr].Name+", "+(arr[itr].Distance*1000).toFixed(1));
                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            const mar = L.marker([arr[itr].Latitude, arr[itr].Longitude], 
                            {
                                clickable: true,
                                id: arr[itr].ids*1941,
                            }).addTo(map);

                            mar.bindPopup(arr[itr].Name + " " + (arr[itr].Distance * 1000).toFixed(1) + "m", { autoClose: false, autoPan: false }).openPopup();
                            map.setView([lat, lon], 16);

                            itr++;
                        });
                    }
                })
            .catch(error => {
                console.error("Error fetching bus stops:", error);
            });
    }
</script>
</html>