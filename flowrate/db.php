<?php
            // Replace with your actual database connection and data retrieval logic
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "temphumidnew";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            ?>