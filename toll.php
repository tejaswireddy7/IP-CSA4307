<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Kolkata');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tollgate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (vehicle_number, vehicle_type, owner_name, email, phone, toll_amount, date, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssssss", $vehicle_number, $vehicle_type, $owner_name, $email, $phone, $toll_amount, $date, $time);

// Set parameters
$vehicle_number = $_POST['vehicle_number'];
$vehicle_type = $_POST['vehicle_type'];
$owner_name = $_POST['owner_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$toll_amount = $_POST['toll_amount'];
$date = date("Y-m-d");
$time = date("H:i:s");

// Execute
if ($stmt->execute()) {
    echo "<h2 style='color:green;text-align:center;'>Toll submitted successfully!</h2>";
    echo "<p style='text-align:center;'><a href='toll.php'>Back to Form</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
