<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mysql";

    $lat = $_POST['lati'];
    $lon = $_POST['long'];

    // Store the values in session variables
    $_SESSION['latitude'] = $lat;
    $_SESSION['longitude'] = $lon;

    // Validation of latitude and longitude
    if (!isset($lat) || !isset($lon) || !is_numeric($lat) || !is_numeric($lon)) {
        echo json_encode(['error' => 'Invalid latitude or longitude']);
        exit;
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT `Sl.No.`, `Stopname`, `Latitude`, `Longitude`, `PostalCode`, 
        (6371 * acos(cos(radians($lat)) * cos(radians(`Latitude`)) * cos(radians(`Longitude`) - radians($lon)) + sin(radians($lat)) * sin(radians(`Latitude`)))) AS distance 
        FROM `bustime` 
        ORDER BY distance 
        LIMIT 3";

    $result = $conn->query($query);

    $busStopData = array();

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $busStopData[] = array(
                'SerialNo' => $row["Sl.No."],
                'Stopname' => $row["Stopname"],
                'Latitude' => $row["Latitude"],
                'Longitude' => $row["Longitude"],
                'PostalCode' => $row["PostalCode"],
                'Distance' => $row["distance"],
            );
        }
    }
    header('Content-Type: application/json');
    $encoded=json_encode($busStopData, JSON_PRETTY_PRINT);
    echo json_encode($encoded);
    file_put_contents('stops.json', $encoded);
?>
