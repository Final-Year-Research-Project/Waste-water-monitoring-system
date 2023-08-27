<!DOCTYPE html>
<html>
<head>
    <title>amperage Pulse Chart</title>
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

        
    </style>
</head>
<body>
    <div class="container">
    <a href="./" class="cancel-icon">
            <i class="fas fa-times"></i>
        <h1>amperage Pulse Chart</h1>
        <div class="chart-container">
            <canvas id="amperageChart" width="400" height="200"></canvas>
            
        </a>
        </div>
        
        <button id="downloadPdf">Download PDF</button>
    </div>
    </div>

    <script>
        var ctx = document.getElementById('amperageChart').getContext('2d');

        var amperageData = <?php
            // Replace with your actual database connection and data retrieval logic
            require_once "db.php";

            $sql = "SELECT * FROM dht11 ORDER BY date DESC LIMIT 10";
            $result = $conn->query($sql);

            $amperageData = array();
            while ($row = $result->fetch_assoc()) {
                $amperageData[] = $row;
            }

            $conn->close();
            
            echo json_encode($amperageData);
        ?>;

var downloadPdfButton = document.getElementById('downloadPdf');
    downloadPdfButton.addEventListener('click', function () {
        var pdfContainer = document.getElementById('amperageChart');
        var pdfOptions = {
            margin: 10,
            filename: 'amperage_chart.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().from(pdfContainer).set(pdfOptions).outputPdf().then(function (pdf) {
            var blob = new Blob([pdf], { type: 'application/pdf' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'amperage_chart.pdf';
            link.click();
        });
    });


        
        var timestamps = amperageData.map(data => data.date);
        var amperages = amperageData.map(data => data.amperage);

        var amperageChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: timestamps,
                datasets: [{
                    label: 'amperage Data',
                    data: amperages,
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

    setInterval(refreshPage, 15000); // Reload every 15 second
    </script>
</body>
</html>
