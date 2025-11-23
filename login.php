<?php
session_start();
include('Conn.php');

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Working prepared statement
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if match found
    if ($result->num_rows === 1) {
        $_SESSION['email'] = $email;
        header("Location: insert.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

        .login-box {
            width: 380px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .login-box h3 {
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

<div class="login-box">
    <h3>Login</h3>

    <?php if ($error != "") { echo "<p class='error'>$error</p>"; } ?>

    <form method="POST">
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="Enter Email">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter Password">
        </div>

        <button type="submit" name="login" class="btn btn-custom btn-block">Login</button>
    </form>
</div>

</body>
</html>
