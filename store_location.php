<?php
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";  // Change if needed
$database = "university_feedback";  // Ensure this matches your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get POST data (use correct column names)
$stakeholder = $_POST['stakeholder'] ?? '';  // ✅ Corrected from 'stakeholderType'
$academic_year = $_POST['academic_year'] ?? '';
$branch = $_POST['branch'] ?? '';
$specialization = $_POST['specialization'] ?? '';
$date = $_POST['date'] ?? '';
$location = $_POST['location'] ?? '';

if (empty($location)) {
    die(json_encode(["status" => "error", "message" => "Location is missing."]));
}

// ✅ Use correct column names as per your database
$sql = "INSERT INTO feedback (stakeholder, academic_year, branch, specialization, date, location) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $stakeholder, $academic_year, $branch, $specialization, $date, $location);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Location stored successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
