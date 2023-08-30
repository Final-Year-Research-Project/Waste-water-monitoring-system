<!DOCTYPE html>
<html>
<head>
    <title>Combined Pulse Chart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 40px;
            top:110%;
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
            height: 400px;
            width: 1000px;
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
    <h1>Combine Pulse Chart
            <a href="./" class="cancel-icon">
                <i class="fas fa-times"></i>
            </a>
        </h1>
        <div class="chart-container">
            <canvas id="combinedChart" width="400" height="200"></canvas>
        </div>
        <button id="downloadPdf">Download PDF</button>
    </div>

    <script>
        var ctx = document.getElementById('combinedChart').getContext('2d');

        // Database connection and data retrieval using PHP
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "temphumidnew";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $temperatureData = array();
            $humidityData = array();
            $vibrationData = array();
            $amperageData = array();

            $temperatureQuery = "SELECT * FROM dht11 ORDER BY date DESC LIMIT 10";
            $humidityQuery = "SELECT * FROM dht11 ORDER BY date DESC LIMIT 10";
            $vibrationQuery = "SELECT * FROM dht11 ORDER BY date DESC LIMIT 10";
            $amperageQuery = "SELECT * FROM dht11 ORDER BY date DESC LIMIT 10";

            $temperatureResult = $conn->query($temperatureQuery);
            while ($row = $temperatureResult->fetch_assoc()) {
                $temperatureData[] = $row;
            }

            $humidityResult = $conn->query($humidityQuery);
            while ($row = $humidityResult->fetch_assoc()) {
                $humidityData[] = $row;
            }

            $vibrationResult = $conn->query($vibrationQuery);
            while ($row = $vibrationResult->fetch_assoc()) {
                $vibrationData[] = $row;
            }

            $amperageResult = $conn->query($amperageQuery);
            while ($row = $amperageResult->fetch_assoc()) {
                $amperageData[] = $row;
            }

            $conn->close();
        ?>

        // Create the combined chart using the retrieved data
        var timestamps = <?php echo json_encode(array_reverse(array_column($temperatureData, 'date'))); ?>;
        var temperatureValues = <?php echo json_encode(array_reverse(array_column($temperatureData, 'temperature'))); ?>;
        var humidityValues = <?php echo json_encode(array_reverse(array_column($humidityData, 'humidity'))); ?>;
        var vibrationValues = <?php echo json_encode(array_reverse(array_column($vibrationData, 'vibration'))); ?>;
        var amperageValues = <?php echo json_encode(array_reverse(array_column($amperageData, 'amperage'))); ?>;

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

        function refreshPage() {
            location.reload();
        }

        setInterval(refreshPage, 15000); // Reload every 15 seconds
    </script>
</body>
</html>
