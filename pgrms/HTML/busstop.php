<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mysql";

    $lat = $_POST['lati'];
    $lon = $_POST['long'];

    if (!isset($lat) || !isset($lon) || !is_numeric($lat) || !is_numeric($lon)) {
        echo json_encode(['error' => 'Invalid latitude or longitude']);
        exit;
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = $conn->prepare("SELECT `Sl.No.`, `Stopname`, `Latitude`, `Longitude`, `PostalCode`, 
        (6371 * acos(cos(radians(?)) * cos(radians(`Latitude`)) * cos(radians(`Longitude`) - radians(?)) + sin(radians(?)) * sin(radians(`Latitude`)))) AS distance 
        FROM `bustime` 
        HAVING distance < 1
        ORDER BY distance");

    $query->bind_param("dds", $lat, $lon, $lat);
    $query->execute();
    $result = $query->get_result();

    $busStopData = array();

    if ($result->num_rows > 0) 
    {
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
    $encoded = json_encode($busStopData, JSON_PRETTY_PRINT);

    $filePath = 'stops.json';
    if (file_put_contents($filePath, $encoded) === false) {
        echo json_encode(['error' => 'Unable to write to file']);
    } else {
        echo $encoded;
    }

    $query->close();
    $conn->close();
?>
