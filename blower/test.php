<!DOCTYPE html>
<html>
<head>
    <!-- Include your CSS and JavaScript links here -->
</head>
<body>
   
    
    <!-- Weather Sidebar and other HTML content -->
    
    <h1>Blower Dashboard</h1>

    <div class="content">
        <?php
        // Create a dummy data array
        $dummyData = array(
            'humidity' => 90,
            'temperature' => 40,
            'vibration' => 17,
            'amperage' => 5
        );

        // Convert the dummy data array to JSON
        $dummyJsonData = json_encode($dummyData);

        // Set the Flask server URL
        $serverUrl = 'http://127.0.0.1:5000/predict';

        // Initialize cURL
        $ch = curl_init($serverUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dummyJsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Execute cURL and get the response
        $response = curl_exec($ch);

        // Close cURL
        curl_close($ch);

        // Decode the response JSON
        $prediction = json_decode($response, true);

        // Display the prediction or error message
        if (isset($prediction['prediction'])) {
            echo '<div class="card card-predicted">';
            echo '<h2><i class="fas fa-heartbeat icon"></i> Blower Health</h2>';
            echo '<p>Predicted: ' . $prediction['prediction'] . '%</p>';
            echo '<a href="your-chart-page.html" class="chart-link">';
            echo '<i class="fas fa-chart-line chart-icon"></i>';
            echo '</a>';
            echo '</div>';
        } else if (isset($prediction['error'])) {
            echo '<p>An error occurred while getting prediction: ' . $prediction['error'] . '</p>';
        }
        ?>
    </div>

    <!-- Include your JavaScript code here -->
</body>
</html>
