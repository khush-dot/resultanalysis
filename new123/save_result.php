<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "result_analysis");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $branch = $_POST["branch"];
    $semester = $_POST["semester"];
    $students = $_POST["students"];
    $num_subjects = $_POST["num_subjects"];

    for ($i = 1; $i <= $num_subjects; $i++) {
        if (!isset($_POST["subject$i"])) continue;

        $subject_name = $_POST["subject$i"];
        $max_marks = $_POST["subject{$i}_maxMarks"];
        $subject_type = isset($_POST["subject{$i}_type"]) ? implode(", ", $_POST["subject{$i}_type"]) : "";

        $sql = "INSERT INTO results (branch, semester, subject_name, subject_type, max_marks, students_enrolled) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissii", $branch, $semester, $subject_name, $subject_type, $max_marks, $students);
        $stmt->execute();
    }

    echo "<script>alert('Data Added Successfully!'); window.location.href='enter_data.html';</script>";

    $stmt->close();
    $conn->close();
}
?>