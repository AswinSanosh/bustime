<!DOCTYPE html>
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
            $arra=Array();

            if($result->num_rows > 0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    //echo '<script>alert("' .$row["Bus name"]. '")</script>';
                    $busname=$row["Bus name"];
                    $busartime=$row["Time of arrival"];
                    $busretime=$row["Time of last stop"];
                    $busstopname=$row["Stop Name"];
                    $buslastop=$row["Last Stop"];

                    $rowData = array(
                        "BusName" => $busname,
                        "ArrivalTime" => $busartime,
                        "LastStopTime" => $busretime,
                        "StopName" => $busstopname,
                        "LastStop" => $buslastop
                    );

                    $arra[$busname] = $rowData;
                }
            } 
            else 
            {
                echo "No data found for Stop Name: $stopName";
            }
            $conn->close();
        }
    ?>
    <section id="ctent">
        <div class="btn">
            <div onload="al()" id="cont"></div>
            <div id="table"></div>
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
    <section id="footer"></section>
        <div id="sidenav" style="right:-250px;">
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
    <script>
        var busDetails = <?php echo json_encode($arra); ?>;

        function createButtons() {
            var container = document.getElementById("cont");

            for (var busName in busDetails) 
            {
                if (busDetails.hasOwnProperty(busName)) 
                {
                    var button = document.createElement("button");
                    button.style.cursor="pointer";
                    button.textContent = busDetails[busName]["BusName"]+" - at"+busDetails[busName]["ArrivalTime"] + " To:"+busDetails[busName]["LastStop"];
                    button.onclick = (function(name)
                    {
                        return function() 
                        {
                            showDetails(name);
                        };
                    })(busName);
                    cont.appendChild(button);
                }
            }
        }
        var previousDiv = null;

        function showDetails(busName) 
        {
            var details = busDetails[busName];

            if (previousDiv) 
            {
                document.getElementById("table").removeChild(previousDiv);
            }

            const newdiv = document.createElement("div");
            newdiv.id = (details.BusName)
            
            const newtable = document.createElement("table");
            newtable.id="tab";

            for (var prop in details)
            {
                if (details.hasOwnProperty(prop)) 
                {
                    const newRow = document.createElement("tr");

                    const headingCell = document.createElement("td");
                    headingCell.textContent = prop;
                    newRow.appendChild(headingCell);

                    const detailsCell = document.createElement("td");
                    detailsCell.textContent = details[prop];
                    newRow.appendChild(detailsCell);

                    newtable.appendChild(newRow);
                }
            }

            newdiv.appendChild(newtable);
            document.getElementById("table").appendChild(newdiv);
            previousDiv = newdiv;
        }

        window.onload = createButtons;
        document.body.style.color="black";
    </script>
</section>
</body>
</html>