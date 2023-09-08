<!DOCTYPE html>
<html>
<head>
    <title>Temperature Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        
        .sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            transition: 0.3s;
            overflow-y: auto;
        }
        
        .sidebar a {
            display: block;
            padding: 15px 20px;
            font-size: 16px;
            border-bottom: 1px solid #4d5256;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s;
        }
        
        .sidebar a:last-child {
            border-bottom: none;
        }
        
        .sidebar a:hover {
            background-color: #212529;
        }

        .weather-sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #007bff;
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
            width: 500px;
            height: 80%;
            background-color: #3498db;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: 0.3s;
            position: relative;
            text-align: center;
            font-size: 28px;
            left: 150px;
        }

        .chart-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #fff;
        }
        
        h1 {
            margin-bottom: 20px;
            color: #333;
            text-align: center; 
            font-size: 50px;
        }
        
        h2 {
            margin-top: 0;
            font-size: 30px;
            display: flex;
            align-items: center;
        }
        
        .icon {
            margin-right: 10px;
            font-size: 25px;
        }
        
        .card-predicted {
            width: 500px;
            height: 80%;
            background-color: #87CEEB;
            color: #333;
            text-align: center;
            top: 230px;
            position: relative;
            left: -132px;
        }
        
        .weather-details {
            padding: 20px;
            color: #fff;
        }

        .weather-details button {
            background-color: #0056b3;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .weather-details button:hover {
            background-color: #003a73;
        }

        .company-name {
            text-align: center;
            padding: 20px 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            border-bottom: 1px solid #4d5256;
        }
    </style>
</head>
<body>
    <?php include '../unique/sidebar.php'; ?>
    
    <div class="weather-sidebar">
        <h2><i class="fas fa-cloud-sun icon"></i> Live Weather</h2>
        <div class="weather-details">
            <p>Select a district:</p>
            <select id="districtSelect">
                <option value="colombo">Colombo</option>
                <option value="kandy">Kandy</option>
                <!-- Add more districts here -->
            </select>
            <button onclick="getWeather()">Get Weather</button>
            <div id="weatherData"></div>
        </div>
    </div>
    
    <h1>Temperature Dashboard</h1>

    <div class="content">
        <?php
        // Database connection details
        require_once "db.php";

        // Query data
        $sql = "SELECT * FROM temp ORDER BY date DESC LIMIT 1";
        $result = $conn->query($sql);

        // Display data in cards
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            
            <div class="card">
                <h2><i class="fas fa-thermometer-half icon"></i> Temperature (C)</h2>
                <p><?php echo $row["temp"]; ?></p>
                <a href="temp.php" class="chart-link">
                <i class="fas fa-chart-line chart-icon"></i>
                </a>
            </div>
            

            <!-- Temperature prediction Card -->
            <div class="card card-predicted">
                <h2><i class="fas fa-heartbeat icon"></i> </h2>
                <p>Predicted: 85%</p>
                <a href="your-chart-page.html" class="chart-link">
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

        setInterval(refreshPage, 5000); // Reload every 5 seconds
    </script>
</body>
