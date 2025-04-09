<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $enrollment_number = $_POST['enrollment_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = new mysqli("localhost", "root", "", "result_analysis");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO students (username, enrollment_number, password) VALUES ('$username', '$enrollment_number', '$password')";
    if ($conn->query($sql) ){
        echo "Registered Successfully!";
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
    <title>Student Registration</title>
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
            width: 300px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .success-message {
            display: none;
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>
        <form id="registrationForm" method="POST">
            <input type="text" id="username" name="username" placeholder="Enter Username" required>
            <input type="text" id="enrollment_number" name="enrollment_number" placeholder="Enter Enrollment Number" required>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <input type="password" id="confirm_password" placeholder="Confirm Password" required>
            
            <button type="submit">Register</button>
        </form>
        <p class="success-message" id="successMessage">Registered Successfully!</p>
    </div>

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            
            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                event.preventDefault();
            } else {
                document.getElementById("successMessage").style.display = "block";
            }
        });
    </script>
</body>
</html>