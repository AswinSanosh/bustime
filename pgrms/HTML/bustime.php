<html>
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
            width: 100%;
            z-index: 0;
        }
    </style>
</HEAD>
<body>
<section id="page">
    <section id="header">
        <a href="Home.html"><img src="image\logo bgr.png" alt="image not found!" class="logo"></a>
    </section>
    <?php
    if(isset($_POST["subm"]))
    {
        $id = $_POST["sessid"];
        $arr = explode(") ", $id);
        //echo '<script>alert("' . $arr[1] . '")</script>';

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mysql";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }

        $stopName = $arr[1];

        $sql = "SELECT * FROM bus WHERE `Stop Name` = '$stopName'";
        $result = $conn->query($sql);

        if($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                //echo '<script>alert("' .$row["Bus name"]. '")</script>';
                echo "Bus name: " . $row["Bus name"] . "<br>";
                echo "Time of arrival: " . $row["Time of arrival"] . "<br>";
                echo "Time of Reaching last stop: " . $row["Time of last stop"] . "<br>";
                echo "Current Stop Name: " . $row["Stop Name"] . "<br>";
                echo "Last Stop". $row["Last Stop"] . "<br>";

                while($row = $result->fetch_assoc()) 
                {
                    $fetchedData[] = array(
                        "BusName" => $row["BusName"],
                        "TimeOfArrival" => $row["TimeOfArrival"],
                        "TimeOfLastStop" => $row["TimeOfLastStop"],
                        "StopName" => $row["StopName"]
                    );
                    $jsonString = json_encode($fetchedData, JSON_PRETTY_PRINT);
                    file_put_contents("bus.json", $jsonString);
                }
            }
        } 
        else 
        {
            echo "No data found for Stop Name: $stopName";
        }

        $conn->close();
    }
    ?>
    <section id="footer"></section>
        <div id="sidenav">
            <nav>
                <ul>
                    <li><a href="Home.html">Home</a></li>
                    <li><a href="tickets.html">My tickets</a></li>
                    <li><a href="dashboard.html">Dashboard</a></li>
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
    </section>
</section>
</body>
</html>