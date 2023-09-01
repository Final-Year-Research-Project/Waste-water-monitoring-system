<!DOCTYPE html>
<html>
<head>
<title>Blower Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        
        .sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529; /* Darker background color */
            color: white;
            padding-top: 20px;
            transition: 0.3s;
            overflow-y: auto; /* Enable scrollbar if content overflows */
        }
        
        .sidebar a {
            display: block;
            padding: 15px 20px;
            font-size: 16px;
            border-bottom: 1px solid #444; /* Add a separator line between links */
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }
        
        .sidebar a:last-child {
            border-bottom: none; /* Remove the separator line for the last link */
        }
        
        .sidebar a:hover {
            background-color: #555;
        }

        .weather-sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #0056b3; /* Darker blue color */
            color: white;
            padding-top: 20px;
            transition: 0.3s;
        }
        
        .content {
            margin-left: 250px;
            margin-right: 250px;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: 0.3s;
            position: relative;
        }

        .chart-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    color: #3498db;
}
        
        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center; 
        }
        
        h2 {
            margin-top: 0;
            font-size: 18px;
            display: flex;
            align-items: center;
        }
        
        .icon {
            margin-right: 10px;
            font-size: 24px;
        }
        
        .card-predicted {
            background-color: #f5f5f5;
            color: #333;
            text-align: center;
        }
        
        /* Additional styles for the weather sidebar */
        .weather-details {
            padding: 20px;
            color: white;
        }

        .weather-details button {
            background-color: #007bff; /* Blue button color */
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .weather-details button:hover {
            background-color: #0056b3; /* Darker blue color on hover */
        }

        .company-name {
            text-align: center;
            padding: 20px 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            border-bottom: 1px solid #444; /* Separator line below company name */
        }
        
            
        
    </style>
</head>
<body>
    <?php include '../unique/sidebar.php'; ?>
    
    <h1>Flow Rate Dashboard</h1>

    <div class="content">
        <?php
        // Database connection details
        require_once "db.php";

        // Query data
        $sql = "SELECT * FROM flowrate ORDER BY ID DESC LIMIT 1";
        $result = $conn->query($sql);

        // Display data in cards
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            
            <div class="card">
                <h2><i class="fas fa-tint icon"></i> Flow In Rate</h2>
                <p><?php echo $row["flow_in"]; ?></p>
                <a href="flowin.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>
            
            <div class="card">
                <h2><i class="fas fa-tint icon"></i> Flow Out Rate</h2>
                <p><?php echo $row["flow_out"]; ?></p>
                <a href="flowout.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>
            <div class="card">
                <h2><i class="fas fa-thermometer-half icon"></i> Temperature</h2>
                <p><?php echo $row["temperature"]; ?></p>
                <a href="temp.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>
            <br/>
            <div class="card">
                <h2><i class="fas fa-vial icon"></i> Blockages Detected</h2>
                <p><?php echo $row["blockage"]; ?></p>
                <a href="vib.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>
    
            <div class="card">
                <h2><i class="fas fa-bolt icon"></i> Chemical </h2>
                <p><?php echo $row["chemical"]; ?></p>
                <a href="amp.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>

            
            <?php
        } else {
            echo "No data available.";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>

    <script>
        function getWeather() {
            const apiKey = 'YOUR_OPENWEATHERMAP_API_KEY';
            const district = document.getElementById('districtSelect').value;
            const weatherDataElement = document.getElementById('weatherData');

            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${district},lk&appid=${apiKey}&units=metric`)
                .then(response => response.json())
                .then(data => {
                    const temperature = data.main.temp;
                    const description = data.weather[0].description;
                    weatherDataElement.innerHTML = `<p>Temperature: ${temperature}°C</p><p>Description: ${description}</p>`;
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        }
        function refreshPage() {
        location.reload();
    }

    setInterval(refreshPage, 5000); // Reload every 5 second
    </script>
</body>
</html>