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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_number = $_POST['vehicle_number'] ?? '';
    $vehicle_type = $_POST['vehicle_type'] ?? '';
    $owner_name = $_POST['owner_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $toll_amount = $_POST['toll_amount'] ?? '';

    // Prepare and execute the insertion query
    $stmt = $conn->prepare("INSERT INTO users (vehicle_number, vehicle_type, owner_name, email, phone, toll_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $vehicle_number, $vehicle_type, $owner_name, $email, $phone, $toll_amount);

    if ($stmt->execute()) {
        echo "<p>Record added successfully! <a href='index.html'>Go Back</a></p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>