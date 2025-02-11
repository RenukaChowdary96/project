<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stakeholderType = $_POST['stakeholderType'] ?? '';
    $academicYear = $_POST['academicYear'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $specialization = $_POST['specialization'] ?? '';
    $feedbackDate = $_POST['feedbackDate'] ?? '';

    if (empty($stakeholderType) || empty($academicYear) || empty($branch) || empty($specialization) || empty($feedbackDate)) {
        die("Error: Missing required fields.");
    }

    // Store data in Local Storage & Redirect to index.html for location selection
    echo "
    <script>
        localStorage.setItem('stakeholderType', '$stakeholderType');
        localStorage.setItem('academicYear', '$academicYear');
        localStorage.setItem('branch', '$branch');
        localStorage.setItem('specialization', '$specialization');
        localStorage.setItem('feedbackDate', '$feedbackDate');
        window.location.href = 'index.html'; 
    </script>";
} else {
    echo "Invalid request method.";
}
?>
