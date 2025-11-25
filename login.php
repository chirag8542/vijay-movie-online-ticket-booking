<?php
session_start();
include('Conn.php');

$error = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fixed SQL query (removed typo)
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if match found
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: insert.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Vijay Movie Tickets</title>
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff10" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
            z-index: 0;
        }

        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1;
        }

        .login-left {
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

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="%23ffffff10"/></svg>');
            background-size: cover;
            animation: float 15s infinite linear;
            z-index: 0;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-50px, -50px) rotate(360deg); }
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

        .features {
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .feature i {
            font-size: 1.2rem;
            margin-right: 15px;
            color: #ffcc00;
            width: 25px;
            text-align: center;
        }

        .login-right {
            flex: 1;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.95);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 2rem;
            color: #1a2a6c;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
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

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(106, 17, 203, 0.6);
        }

        .btn-login:active {
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

        .additional-options {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .remember-me input {
            margin-right: 8px;
        }

        .forgot-password a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #6a11cb;
            font-weight: 600;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 950px) {
            .login-container {
                width: 90%;
                height: auto;
                flex-direction: column;
            }
            
            .login-left, .login-right {
                padding: 30px;
            }
        }

        @media (max-width: 500px) {
            .login-container {
                width: 95%;
            }
            
            .brand-text h1 {
                font-size: 1.7rem;
            }
            
            .login-header h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <div class="brand">
                <i class="fas fa-film"></i>
                <div class="brand-text">
                    <h1>Vijay Movie Tickets</h1>
                    <p>Your gateway to cinematic experiences</p>
                </div>
            </div>
            
            <div class="features">
                <div class="feature">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Easy ticket booking</span>
                </div>
                <div class="feature">
                    <i class="fas fa-calendar-check"></i>
                    <span>Instant confirmation</span>
                </div>
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <span>Secure payment processing</span>
                </div>
                <div class="feature">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Mobile-friendly experience</span>
                </div>
            </div>
        </div>
        
        <div class="login-right">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue</p>
            </div>
            
            <?php if ($error != "") { echo "<div class='error-message'><i class='fas fa-exclamation-circle'></i> $error</div>"; } ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                
                <div class="additional-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="forgot-password">
                        <a href="#">Forgot password?</a>
                    </div>
                </div>
                
                <button type="submit" name="login" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up now</a>
            </div>
        </div>
    </div>

    <script>
        // Simple animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const loginContainer = document.querySelector('.login-container');
            loginContainer.style.opacity = '0';
            loginContainer.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                loginContainer.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                loginContainer.style.opacity = '1';
                loginContainer.style.transform = 'translateY(0)';
            }, 100);
        });

        // Add focus effects to inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>