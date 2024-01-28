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
            
                // Google Custom Search API endpoint with location query
                $apiEndpoint = "https://www.googleapis.com/customsearch/v1?q=bus+stops+near&cx=$cx&key=$apiKey&near=$latitude,$longitude";
            
                // Initialize cURL session
                $ch = curl_init($apiEndpoint);
            
                // Set cURL options
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
                // Execute cURL session and get the JSON response
                $response = curl_exec($ch);
            
                // Check for cURL errors
                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }
            
                // Close cURL session
                curl_close($ch);
            
                // Decode the JSON response
                $results = json_decode($response, true);
            
                // Output the results (you might want to format this according to your needs)
                print_r($results);
            } 
            else 
            {
                echo 'Error: Latitude and longitude not provided.';
            }
        }
    ?>