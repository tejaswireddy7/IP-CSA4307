<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "tollgate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission to insert new records
$success_message = ""; // To store success notification

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $_POST['vehicle_number'] ?? '';
    $vehicle_type = $_POST['vehicle_type'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $toll_amount = $_POST['toll_amount'] ?? '';

    // Insert new record into the database
    $stmt = $conn->prepare("INSERT INTO users (vehicle_number, vehicle_type, owner_name, email, phone, toll_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $vehicle_number, $vehicle_type, $owner_name, $email, $phone, $toll_amount);

    if ($stmt->execute()) {
        $success_message = "Record applied successfully!";
    } else {
        $success_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record Status - Online Toll Gate System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: url("success.jpg") no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
        }

        .container {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            width: 400px;
            text-align: center;
            color: black;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .message {
            font-size: 1.2em;
            font-weight: bold;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: white;
        }

        .success {
            background-color: #28a745;
        }

        .error {
            background-color: #dc3545;
        }

        .back-button {
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="overlay"></div> <!-- Semi-transparent overlay for readability -->
    <div class="container">
        <h1>Online Toll Gate System</h1>

        <!-- Success or Error Message -->
        <?php if ($success_message): ?>
            <p class="message <?= strpos($success_message, 'Error') !== false ? 'error' : 'success' ?>">
                <?= htmlspecialchars($success_message) ?>
            </p>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="Homepage.html" class="back-button">Go Back</a>
    </div>
</body>
</html>