<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stakeholder = $_POST['stakeholder'] ?? '';  
    $academic_year = $_POST['academicYear']; // ✅ Fixed column name
    $branch = $_POST['branch'];
    $specialization = $_POST['specialization'];
    $date = $_POST['date'];
    $location = $_POST['location'];

    // Feedback answers
    $question1 = $_POST['question1'];
    $question2 = $_POST['question2'];
    $question3 = $_POST['question3'];
    $question4 = $_POST['question4'];
    $question5 = $_POST['question5'];
    $question6 = $_POST['question6'];
    $question7 = $_POST['question7'];
    $question8 = $_POST['question8'];
    $question9 = $_POST['question9'];
    $question10 = $_POST['question10'];

    // Check if the record exists
    $check_sql = "SELECT * FROM feedback WHERE stakeholder='$stakeholder' 
                  AND academic_year='$academic_year' 
                  AND branch='$branch' 
                  AND specialization='$specialization' 
                  AND date='$date' 
                  AND location='$location'";

    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Update the existing record
        $sql = "UPDATE feedback SET
            question1 = '$question1',
            question2 = '$question2',
            question3 = '$question3',
            question4 = '$question4',
            question5 = '$question5',
            question6 = '$question6',
            question7 = '$question7',
            question8 = '$question8',
            question9 = '$question9',
            question10 = '$question10'
            WHERE stakeholder='$stakeholder' 
            AND academic_year='$academic_year' 
            AND branch='$branch' 
            AND specialization='$specialization' 
            AND date='$date' 
            AND location='$location'";
    } else {
        // Insert a new record if it doesn't exist
        $sql = "INSERT INTO feedback 
            (stakeholder, academic_year, branch, specialization, date, location, 
            question1, question2, question3, question4, question5, 
            question6, question7, question8, question9, question10) 
            VALUES 
            ('$stakeholder', '$academic_year', '$branch', '$specialization', '$date', '$location', 
            '$question1', '$question2', '$question3', '$question4', '$question5', 
            '$question6', '$question7', '$question8', '$question9', '$question10')";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Feedback submitted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
