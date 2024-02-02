<?php
    // busstop.php

    // Sample data (replace this with your actual data retrieval logic)
    $busStopData = array(
        'name' => 'Bus Stop 1',
        'location' => 'City Center',
        // Add more data fields as needed
    );

    // Encode the data as JSON and return it
    header('Content-Type: application/json');
    echo json_encode($busStopData);
?>