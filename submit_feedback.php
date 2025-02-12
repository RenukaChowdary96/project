<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stakeholderType = $_POST['stakeholderType'] ?? ''; // Ensure correct variable name

    $academic_year = $_POST['academicYear']; 
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

    // Check if a record exists
    $check_sql = "SELECT id FROM feedback WHERE 
        stakeholder='$stakeholderType' 
        AND academic_year='$academic_year' 
        AND branch='$branch' 
        AND specialization='$specialization' 
        AND date='$date' 
        AND location='$location'";

    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // Update existing record
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
            WHERE stakeholder='$stakeholderType' 
            AND academic_year='$academic_year' 
            AND branch='$branch' 
            AND specialization='$specialization' 
            AND date='$date' 
            AND location='$location'";
    } else {
        // Insert new record
        $sql = "INSERT INTO feedback (stakeholder, academic_year, branch, specialization, date, location, 
            question1, question2, question3, question4, question5, 
            question6, question7, question8, question9, question10) 
            VALUES ('$stakeholderType', '$academic_year', '$branch', '$specialization', '$date', '$location', 
            '$question1', '$question2', '$question3', '$question4', '$question5', 
            '$question6', '$question7', '$question8', '$question9', '$question10')";
    }

    if (mysqli_query($conn, $sql)) {
        // Redirect to thanks.html on success
        header("Location: thanks.html");
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
