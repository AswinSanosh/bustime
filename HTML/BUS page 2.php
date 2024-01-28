<!DOCTYPE HTML>
<HEAD>
    <TITLE>BUS TIME</TITLE>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <LINK rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&display=swap" rel="stylesheet">
</HEAD>
<body>
    <section id="header">
        <img src="image/logo.png" alt="image not found!" class="logo">
    </section>
    <section id="ctent">
        <div id="cont">
            <form action="BUS page 2.php" method="get">
                <div class="btn">
                    <button name="sub"><span></span>Bus stops near me</button>
                    <input type="text" name="lon" id="long" hidden>
                    <input type="text" name="lat" id="lat" hidden>
                </div>
            </form>
            <script>
                function getLocation()
                {
                    if (navigator.geolocation)
                    {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } 
                    else 
                    {
                        alert("Geolocation is not supported by this browser.");
                    }
                }
                function showPosition(position)
                {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    document.getElementById(long).value=longitude;
                    document.getElementById(lat).value=latitude;
                    document.getElementById("location").innerHTML = `Your Location: ${latitude}, ${longitude}`;
                }
            </script>
            <?php
                if(isset($_GET['sub']))
                {
                    echo "success";
                    $latitude = isset($_GET['lat']) ? $_GET['lat'] : null;
                    $longitude = isset($_GET['lon']) ? $_GET['lon'] : null;
                    
                    if ($latitude !== null && $longitude !== null) 
                    {
                        $apiKey = 'AIzaSyDot5lrX9NJL7aZ5N47T493d4h4Yu0Vi30';
                        $cx = '22c3c3f0bedc942d6';
                    
                        $apiEndpoint = "https://www.googleapis.com/customsearch/v1?q=bus+stops+near&cx=$cx&key=$apiKey&near=$latitude,$longitude";
                    
                        $ch = curl_init($apiEndpoint);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo 'Curl error: ' . curl_error($ch);
                        }

                        curl_close($ch);
                    
                        // Decode the JSON response
                        $results = json_decode($response, true);
                        print_r($results);
                    } 
                    else 
                    {
                        echo 'Error: Latitude and longitude not provided.';
                    }
                }
            ?>                      
        </div>
    </section>
    <section id="footer">
        <img src="image/logo.png" alt="image not found!" class="logo">
    </section>
    <div id="sidenav">
        <nav>
            <ul>
                <li><a href="BUS page 1.html">Home</a></li>
                <li><a href="#">My tickets</a></li>
                <li><a href="#"></a></li>
                <li><a href="#">Complaints</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
        </nav>
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
</body>