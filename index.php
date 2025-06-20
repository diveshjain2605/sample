<?php
include('session.php');
if (isset($_SESSION['user_name'])) {
    header('Location: welcomepage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Material Design CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        :root {
            --primary-dark: #0f0f23;
            --secondary-dark: #1a1a2e;
            --accent-purple: #6c5ce7;
            --accent-light: #a29bfe;
            --text-primary: #ffffff;
            --text-secondary: #b2b2b2;
            --glass-bg: rgba(108, 92, 231, 0.1);
            --glass-border: rgba(108, 92, 231, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-dark) 50%, #16213e 100%);
            height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: var(--accent-purple);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 1;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 480px;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent-light), transparent);
        }

        .card-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 35px;
            text-align: center;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .input-field input {
            border-bottom: 1px solid rgba(108, 92, 231, 0.3) !important;
            box-shadow: none !important;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px 8px 0 0;
            padding: 15px 10px 5px 10px !important;
            font-size: 16px;
        }

        .input-field input:focus {
            border-bottom: 2px solid var(--accent-light) !important;
            box-shadow: 0 1px 0 0 var(--accent-light) !important;
            background: rgba(255, 255, 255, 0.08);
        }

        .input-field label {
            color: var(--text-secondary) !important;
            font-size: 14px;
        }

        .input-field input:focus + label {
            color: var(--accent-light) !important;
        }

        .input-field .prefix {
            color: var(--text-secondary);
            margin-top: 10px;
        }

        .input-field input:focus ~ .prefix {
            color: var(--accent-light);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.3);
            border: none;
            transition: all 0.4s ease;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 15px 40px;
            color: white;
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-top: 20px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.4);
        }

        .remember-me {
            margin-top: 20px;
            color: var(--text-secondary);
        }

        .remember-me input[type="checkbox"] {
            opacity: 1 !important;
            position: relative;
            left: 0;
            visibility: visible;
        }

        .remember-me label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"]:checked + span {
            color: var(--accent-light);
        }

        .register-link {
            margin-top: 25px;
            text-align: center;
            color: var(--text-secondary);
        }

        .register-link a {
            color: var(--accent-light);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .register-link a:hover {
            color: var(--text-primary);
            text-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="particles" id="particles"></div>

    <div class="login-container">
        <div class="glass-card">
            <h4 class="card-title">Welcome Back</h4>
            <form method="post" action="login_check.php" enctype="multipart/form-data">
                <div class="input-field">
                    <i class="material-icons prefix">person_outline</i>
                    <input type="text" name="username" id="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">lock_outline</i>
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="remember-me">
                    <label>
                        <input type="checkbox" name="remember" class="filled-in" />
                        <span>Remember me</span>
                    </label>
                </div>
                <div class="center-align">
                    <button type="submit" class="btn waves-effect waves-light btn-login">
                        Login <i class="material-icons right">login</i>
                    </button>
                </div>
                <div class="register-link">
                    <p>Don't have an account? <a href="regestration.php">Create one here</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Material Design JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create animated particles
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = 30;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';

                    // Random size between 2-6px
                    const size = Math.random() * 4 + 2;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';

                    // Random position
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';

                    // Random animation delay
                    particle.style.animationDelay = Math.random() * 6 + 's';
                    particle.style.animationDuration = (Math.random() * 4 + 4) + 's';

                    particlesContainer.appendChild(particle);
                }
            }

            createParticles();
        });
    </script>
</body>
</html>
