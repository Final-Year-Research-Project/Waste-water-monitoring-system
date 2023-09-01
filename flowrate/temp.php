<!DOCTYPE html>
<html>
<head>
    <title>Temperature Pulse Chart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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
            position: relative;
        }
        .cancel-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #999;
            text-decoration: none;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Temperature Pulse Chart
            <a href="./" class="cancel-icon">
                <i class="fas fa-times"></i>
            </a>
        </h1>
        <div class="chart-container">
            <canvas id="temperatureChart" width="400" height="200"></canvas>
        </div>
        <button id="downloadPdf">Download PDF</button>
    </div>

    <script>
        var ctx = document.getElementById('temperatureChart').getContext('2d');

        var temperatureData = <?php
            // Replace with your actual database connection and data retrieval logic
            require_once "db.php";

            $sql = "SELECT * FROM flowrate ORDER BY date DESC LIMIT 10";
            $result = $conn->query($sql);

            $temperatureData = array();
            while ($row = $result->fetch_assoc()) {
                $temperatureData[] = $row;
            }

            $conn->close();
            
            echo json_encode($temperatureData);
        ?>;

        var timestamps = temperatureData.map(data => data.date);
        var temperatures = temperatureData.map(data => data.temperature);

        timestamps.reverse();
        temperatures.reverse();

        var temperatureChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timestamps,
                datasets: [{
                    label: 'Temperature Data',
                    data: temperatures,
                    fill: false,
                    borderColor: '#3498db', // Blue color
                    borderWidth: 2,
                    pointBackgroundColor: '#3498db',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
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
