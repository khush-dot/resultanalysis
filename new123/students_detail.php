<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $branch = $_POST['branch'];
    $semester = $_POST['semester'];
    $totalMarks = $_POST['totalMarks'];
    $result = $_POST['result'];
    $percentage = $_POST['percentage'];

    $conn = new mysqli("localhost", "root", "", "result_analysis");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $student_id = $_SESSION['student_id'];
    $sql = "INSERT INTO student_results (student_id, branch, semester, total_marks, result, percentage) VALUES ('$student_id', '$branch', '$semester', '$totalMarks', '$result', '$percentage')";
    if ($conn->query($sql)) {
        echo "Data Added Successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .checkbox-group {
            text-align: left;
            margin-bottom: 10px;
        }
        .radio-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 10px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Fill Details</h2>
        <form id="detailsForm" method="POST">
            <label>Select Branch:</label>
            <select id="branch" name="branch" onchange="updateSubjects()" required>
                <option value="">Select Branch</option>
                <option value="CSE">CSE</option>
                <option value="ECE">ECE</option>
                <option value="ME">ME</option>
            </select>
            
            <label>Select Semester:</label>
            <select id="semester" name="semester" onchange="updateSubjects()" required>
                <option value="">Select Semester</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            
            <div id="subjectsContainer"></div>
            <label>Total Marks:</label>
            <input type="number" id="totalMarks" name="totalMarks" disabled>
            
            <label>Show Result:</label>
            <div class="radio-group">
                <label><input type="radio" name="result" value="Pass"> Pass</label>
                <label><input type="radio" name="result" value="Fail"> Fail</label>
            </div>
            
            <label>Percentage:</label>
            <input type="text" id="percentage" name="percentage" disabled>
            
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
        const subjectsData = {
            "CSE": {
                "1": ["Mathematics", "Physics", "Programming"],
                "2": ["Data Structures", "Algorithms", "Computer Networks"],
                "3": ["Operating Systems", "Database Management", "Software Engineering"]
            },
            "ECE": {
                "1": ["Mathematics", "Physics", "Basic Electronics"],
                "2": ["Digital Logic", "Analog Circuits", "Signals & Systems"],
                "3": ["Microprocessors", "Communication Systems", "VLSI Design"]
            },
            "ME": {
                "1": ["Mathematics", "Physics", "Engineering Drawing"],
                "2": ["Thermodynamics", "Material Science", "Fluid Mechanics"],
                "3": ["Machine Design", "Manufacturing Processes", "Automobile Engineering"]
            }
        };

        function updateSubjects() {
            const branch = document.getElementById("branch").value;
            const semester = document.getElementById("semester").value;
            const subjectsContainer = document.getElementById("subjectsContainer");
            subjectsContainer.innerHTML = "";
            
            if (branch && semester && subjectsData[branch] && subjectsData[branch][semester]) {
                subjectsData[branch][semester].forEach((subject, index) => {
                    const subjectDiv = document.createElement("div");
                    subjectDiv.innerHTML = `
                        <label>${subject}:</label>
                        <div class="checkbox-group">
                            <label><input type="checkbox"> Theory</label>
                            <label><input type="checkbox"> Practical</label>
                            <label><input type="checkbox"> SLA</label>
                        </div>
                        <label>Marks:</label>
                        <input type="number" class="marks" oninput="calculateTotal()">
                    `;
                    subjectsContainer.appendChild(subjectDiv);
                });
            }
        }
        
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll(".marks").forEach(input => {
                total += Number(input.value) || 0;
            });
            document.getElementById("totalMarks").value = total;
            document.getElementById("percentage").value = total / 3 + "%";
        }
    </script>
</body>
</html>