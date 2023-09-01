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
    <div class="sidebar">
        <div class="company-name">
            <img src="../images/Daiki-Logo-c.png" alt="Company Logo" style="max-width: 100px; height: auto;">
            
        </div>
        <a href="../Home" class="sidebar-link">Home</a>
        <a href="../blower/" class="sidebar-link">Blower Dashboard</a>
        <a href="../flowrate/" class="sidebar-link">Flowrate Dashboard</a>
        <a href="../ph/" class="sidebar-link">PH Dashboard</a>
        <a href="../temp/" class="sidebar-link">Temp Dashboard</a>
        <a href="#" class="sidebar-link">Settings</a>
    </div>
</body>
</html>
