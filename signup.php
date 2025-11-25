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
    else if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long!";
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

            // Insert user without password hashing (as in original)
            $stmt = $conn->prepare("INSERT INTO users (email, password, fullname, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $email, $password, $fullname);

            if ($stmt->execute()) {
                $success = "Account created successfully! Redirecting to login...";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>";
            } else {
                $error = "Something went wrong! Please try again.";
            }
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Vijay Movie Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff10" points="0,0 1000,1000 0,1000"/></svg>');
            background-size: cover;
            z-index: 0;
        }

        .signup-container {
            display: flex;
            width: 950px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1;
        }

        .signup-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(26, 42, 108, 0.8), rgba(178, 31, 31, 0.8));
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .signup-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L0,100 Z" fill="%23ffffff10"/></svg>');
            background-size: cover;
            animation: float 20s infinite linear;
            z-index: 0;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(50px, 50px) rotate(360deg); }
        }

        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .brand i {
            font-size: 2.5rem;
            margin-right: 15px;
            color: #ffcc00;
        }

        .brand-text h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .benefits {
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }

        .benefit {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .benefit i {
            font-size: 1.2rem;
            margin-right: 15px;
            color: #ffcc00;
            width: 25px;
            text-align: center;
        }

        .testimonial {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            position: relative;
            z-index: 1;
            border-left: 4px solid #ffcc00;
        }

        .testimonial p {
            font-style: italic;
            margin-bottom: 10px;
        }

        .testimonial .author {
            font-weight: 600;
            text-align: right;
        }

        .signup-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.95);
        }

        .signup-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signup-header h2 {
            font-size: 2rem;
            color: #1a2a6c;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .signup-header p {
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .input-with-icon input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-with-icon input:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 2px rgba(106, 17, 203, 0.2);
            outline: none;
        }

        .password-strength {
            height: 5px;
            background: #eee;
            border-radius: 5px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .password-requirements {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }

        .btn-signup {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.4);
        }

        .btn-signup:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(106, 17, 203, 0.6);
        }

        .btn-signup:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid rgba(231, 76, 60, 0.3);
            font-weight: 500;
        }

        .success-message {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid rgba(46, 204, 113, 0.3);
            font-weight: 500;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #6a11cb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 950px) {
            .signup-container {
                width: 90%;
                height: auto;
                flex-direction: column;
            }
            
            .signup-left, .signup-right {
                padding: 30px;
            }
        }

        @media (max-width: 500px) {
            .signup-container {
                width: 95%;
            }
            
            .brand-text h1 {
                font-size: 1.7rem;
            }
            
            .signup-header h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <div class="signup-left">
            <div class="brand">
                <i class="fas fa-film"></i>
                <div class="brand-text">
                    <h1>Vijay Movie Tickets</h1>
                    <p>Join our movie community today</p>
                </div>
            </div>
            
            <div class="benefits">
                <div class="benefit">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Quick and easy ticket booking</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-calendar-star"></i>
                    <span>Get notified about new releases</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-gift"></i>
                    <span>Exclusive member discounts</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-crown"></i>
                    <span>VIP booking privileges</span>
                </div>
            </div>
            
            <div class="testimonial">
                <p>"Booking tickets through Vijay Movies has never been easier. I love the seamless experience!"</p>
                <div class="author"> vijay </div>
            </div>
        </div>
        
        <div class="signup-right">
            <div class="signup-header">
                <h2>Create Account</h2>
                <p>Join thousands of movie lovers today</p>
            </div>
            
            <?php 
            if ($error != "") { 
                echo "<div class='error-message'><i class='fas fa-exclamation-circle'></i> $error</div>"; 
            } 
            if ($success != "") { 
                echo "<div class='success-message'><i class='fas fa-check-circle'></i> $success</div>"; 
            }
            ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                    <div class="password-requirements">
                        Password must be at least 6 characters long
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    <div id="password-match" class="password-requirements"></div>
                </div>
                
                <button type="submit" name="signup" class="btn-signup">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>

    <script>
        // Simple animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const signupContainer = document.querySelector('.signup-container');
            signupContainer.style.opacity = '0';
            signupContainer.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                signupContainer.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                signupContainer.style.opacity = '1';
                signupContainer.style.transform = 'translateY(0)';
            }, 100);
        });

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength-bar');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 6) strength += 30;
            if (password.length >= 8) strength += 20;
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 10;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 40) {
                strengthBar.style.background = '#e74c3c';
            } else if (strength < 70) {
                strengthBar.style.background = '#f39c12';
            } else {
                strengthBar.style.background = '#2ecc71';
            }
        });

        // Password match validation
        const confirmPasswordInput = document.getElementById('confirm_password');
        const passwordMatch = document.getElementById('password-match');
        
        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== this.value) {
                passwordMatch.innerHTML = '<i class="fas fa-times"></i> Passwords do not match';
                passwordMatch.style.color = '#e74c3c';
            } else {
                passwordMatch.innerHTML = '<i class="fas fa-check"></i> Passwords match';
                passwordMatch.style.color = '#2ecc71';
            }
        });
    </script>
</body>
</html>