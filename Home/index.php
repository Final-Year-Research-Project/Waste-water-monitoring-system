<!DOCTYPE html>
<html>
<head>
    <title>Blower Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, html {
            height: 100%; /* Set the height of both body and html to 100% */
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

        .company-name {
            text-align: center;
            padding: 20px 0;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            border-bottom: 1px solid #444; /* Separator line below company name */
        }

        /* Card styles */
        .card-container {
            margin-left: 250px; /* Adjust for the sidebar width */
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card:hover {
            background-color: #f5f5f5;
        }

        /* Define unique classes for each card */
        .blower-card { background-color: #ffd700; }
        .flowrate-card { background-color: #00ff00; }
        .ph-card { background-color: #ff4500; }
        .temp-card { background-color: #4169e1; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="company-name">Daiki Axis</div>
        <a href="../Home" class="sidebar-link">Home</a>
        <a href="../blower/" class="sidebar-link">Blower Dashboard</a>
        <a href="../flowrate/" class="sidebar-link">Flowrate Dashboard</a>
        <a href="../ph/" class="sidebar-link">PH Dashboard</a>
        <a href="../temp/" class="sidebar-link">Temp Dashboard</a>
        <a href="#" class="sidebar-link">Settings</a>
    </div>

    <!-- Card Container -->
    <div class="card-container">
        <!-- Blower Dashboard Card -->
        <div class="card blower-card" onclick="navigateToPage('../blower/')">
            <h2>Blower Dashboard</h2>
        </div>
        
        <!-- Flowrate Dashboard Card -->
        <div class="card flowrate-card" onclick="navigateToPage('../flowrate/')">
            <h2>Flowrate Dashboard</h2>
        </div>
        
        <!-- PH Dashboard Card -->
        <div class="card ph-card" onclick="navigateToPage('../ph/')">
            <h2>PH Dashboard</h2>
        </div>
        
        <!-- Temp Dashboard Card -->
        <div class="card temp-card" onclick="navigateToPage('../temp/')">
            <h2>Temp Dashboard</h2>
        </div>
    </div>

    <script>
        // JavaScript function to navigate to a page
        function navigateToPage(pageURL) {
            window.location.href = pageURL;
        }
    </script>
</body>
</html>
