<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

header('Content-Type: application/json');  // Set the response type to JSON

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Get form data
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$position = isset($_POST['position']) ? trim($_POST['position']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Validate required fields
if (empty($name) || empty($position) || empty($email)) {
    echo json_encode(["success" => false, "error" => "Missing required fields."]);
    exit;
}

// Insert into database
$sql = "INSERT INTO employees (name, position, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $position, $email);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);  // Return a success message in JSON format
} else {
    echo json_encode(["success" => false, "error" => "Error inserting employee: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
