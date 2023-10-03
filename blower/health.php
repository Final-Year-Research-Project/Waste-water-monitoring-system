<!DOCTYPE html>
<html>
<head>
    <title>Combined Pulse Chart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 40px;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 65px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
        .chart-container {
            margin-bottom: 20px;
        }
        .cancel-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #999;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Combined Pulse Chart
        <a href="./" class="cancel-icon">
                <i class="fas fa-times"></i>
            </a>
        </h1>
        <div class="chart-container">
            <canvas id="combinedChart" width="800" height="400"></canvas>
        </div>
    </div>

    <script>
        // PHP script for data retrieval
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "temphumidnew";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the latest 10 records in ascending order by date
        $sql = "SELECT date, temperature, humidity, vibration, amperage, prediction FROM (SELECT * FROM blower_prediction ORDER BY date DESC LIMIT 10) subquery ORDER BY date ASC";
        $result = $conn->query($sql);

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $conn->close();

        // Encode the data as JSON and make it available to JavaScript
        echo "var chartData = " . json_encode($data) . ";";
        ?>

        // Chart rendering function
        function renderChart() {
            var ctx = document.getElementById('combinedChart').getContext('2d');

            var timestamps = chartData.map(function (entry) {
                return entry.date;
            });
            var temperatureValues = chartData.map(function (entry) {
                return entry.temperature;
            });
            var humidityValues = chartData.map(function (entry) {
                return entry.humidity;
            });
            var vibrationValues = chartData.map(function (entry) {
                return entry.vibration;
            });
            var amperageValues = chartData.map(function (entry) {
                return entry.amperage;
            });
            var predictionValues = chartData.map(function (entry) {
                return entry.prediction;
            });

            var combinedChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: timestamps,
                    datasets: [
                        {
                            label: 'Temperature',
                            data: temperatureValues,
                            fill: false,
                            borderColor: '#3498db',
                            borderWidth: 2,
                            pointBackgroundColor: '#3498db',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Humidity',
                            data: humidityValues,
                            fill: false,
                            borderColor: '#e74c3c',
                            borderWidth: 2,
                            pointBackgroundColor: '#e74c3c',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Vibration',
                            data: vibrationValues,
                            fill: false,
                            borderColor: '#2ecc71',
                            borderWidth: 2,
                            pointBackgroundColor: '#2ecc71',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Amperage',
                            data: amperageValues,
                            fill: false,
                            borderColor: '#f39c12',
                            borderWidth: 2,
                            pointBackgroundColor: '#f39c12',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        },
                        {
                            label: 'Prediction',
                            data: predictionValues,
                            fill: false,
                            borderColor: '#9b59b6',
                            borderWidth: 2,
                            pointBackgroundColor: '#9b59b6',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    }
                }
            });
        }

        // Call the renderChart function after the page loads
        window.addEventListener('load', renderChart);

        function refreshPage() {
            location.reload();
        }

        setInterval(refreshPage, 30000); // Reload every 30 seconds
    </script>
</body>
</html>
