<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "tollgate");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE 1=1";
$params = [];
$types = "";

if (!empty($_POST['vehicle_type'])) {
    $sql .= " AND vehicle_type = ?";
    $params[] = $_POST['vehicle_type'];
    $types .= "s";
}
if (!empty($_POST['toll_amount'])) {
    $sql .= " AND toll_amount = ?";
    $params[] = $_POST['toll_amount'];
    $types .= "s";
}

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        body { font-family: Arial; background-color: #f0f0f0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #333; color: white; }
    </style>
</head>
<body>
    <h2>Search Results</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Vehicle Number</th>
                <th>Vehicle Type</th>
                <th>Owner Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Toll Amount</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['vehicle_number']) ?></td>
                    <td><?= htmlspecialchars($row['vehicle_type']) ?></td>
                    <td><?= htmlspecialchars($row['owner_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['toll_amount']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No records found for the given criteria.</p>
    <?php endif; ?>
    <?php $stmt->close(); $conn->close(); ?>
</body>
</html>