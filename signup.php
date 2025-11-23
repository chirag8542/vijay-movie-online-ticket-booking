<?php
session_start();
include('Conn.php');

$error = "";
$success = "";

if (isset($_POST['signup'])) {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required!";
    } 
    else if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } 
    else {

        // Check if the email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already in use!";
        } else {

            // Insert user without password hashing
            $stmt = $conn->prepare("INSERT INTO users (email, password, fullname, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $email, $password, $fullname);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Something went wrong!";
            }
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Poppins", sans-serif;
            margin: 0;
        }

        .signup-box {
            width: 380px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .signup-box h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }

        .btn-custom {
            background: #6a11cb;
            color: #fff;
            font-weight: bold;
            border-radius: 30px;
        }

        .btn-custom:hover {
            background: #2575fc;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="signup-box">
    <h3>Signup</h3>

    <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" class="form-control" required placeholder="Enter Full Name">
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="Enter Email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter Password">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required placeholder="Confirm Password">
        </div>

        <button type="submit" name="signup" class="btn btn-custom btn-block">Signup</button>
    </form>

    <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>
