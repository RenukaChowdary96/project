<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print received POST data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $stakeholderType = $_POST['stakeholderType'] ?? '';
    $academicYear = $_POST['academicYear'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $specialization = $_POST['specialization'] ?? '';
    $date = $_POST['date'] ?? '';
    $location = $_POST['location'] ?? '';
    $question1 = $_POST['question1'] ?? '';
    $question2 = $_POST['question2'] ?? '';
    $question3 = $_POST['question3'] ?? '';
    $question4 = $_POST['question4'] ?? '';
    $question5 = $_POST['question5'] ?? '';
    $question6 = $_POST['question6'] ?? '';
    $question7 = $_POST['question7'] ?? '';
    $question8 = $_POST['question8'] ?? '';
    $question9 = $_POST['question9'] ?? '';
    $question10 = $_POST['question10'] ?? '';

    if (empty($date) || empty($location)) {
        die("Error: Missing Date or Location.");
    }

    $stmt = $conn->prepare("INSERT INTO feedback (stakeholder, academic_year, branch, specialization, date, location, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error in SQL Statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssssssssssss", $stakeholderType, $academicYear, $branch, $specialization, $date, $location, $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10);

    if ($stmt->execute()) {
        echo "Feedback Submitted Successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
