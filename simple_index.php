<?php
include('session.php');
if (isset($_SESSION['user_name'])) {
    header('Location: simple_welcomepage.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Warehouse Pro</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Simple Design System -->
    <link href="simple_design_system.css" rel="stylesheet">
    
    <style>
        /* ===== LOGIN PAGE STYLES ===== */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-4);
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        
        .login-card {
            background: var(--bg-primary);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid var(--border-light);
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-inverse);
            padding: var(--space-8) var(--space-6) var(--space-6);
            text-align: center;
        }
        
        .login-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            margin-bottom: var(--space-4);
        }
        
        .login-logo .material-icons {
            font-size: 2.5rem;
        }
        
        .login-title {
            font-size: var(--font-size-2xl);
            font-weight: var(--font-bold);
            margin-bottom: var(--space-2);
        }
        
        .login-subtitle {
            font-size: var(--font-size-base);
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: var(--space-8) var(--space-6);
        }
        
        .form-group {
            margin-bottom: var(--space-6);
        }
        
        .form-label {
            display: block;
            font-size: var(--font-size-sm);
            font-weight: var(--font-medium);
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }
        
        .form-input-group {
            position: relative;
        }
        
        .form-input-icon {
            position: absolute;
            left: var(--space-3);
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 1;
        }
        
        .form-input {
            width: 100%;
            padding: var(--space-4) var(--space-4) var(--space-4) var(--space-12);
            font-size: var(--font-size-base);
            line-height: 1.5;
            color: var(--text-primary);
            background: var(--bg-secondary);
            border: 2px solid var(--border-light);
            border-radius: var(--radius-lg);
            transition: all var(--transition-fast);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--bg-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-input:focus + .form-input-icon {
            color: var(--primary);
        }
        
        .form-input::placeholder {
            color: var(--text-muted);
        }
        
        .remember-group {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-6);
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-medium);
            border-radius: var(--radius-sm);
            background: var(--bg-primary);
            cursor: pointer;
            position: relative;
            transition: all var(--transition-fast);
        }
        
        .checkbox:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--text-inverse);
            font-size: 12px;
            font-weight: bold;
        }
        
        .checkbox-label {
            font-size: var(--font-size-sm);
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }
        
        .login-button {
            width: 100%;
            padding: var(--space-4);
            font-size: var(--font-size-base);
            font-weight: var(--font-semibold);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--text-inverse);
            border: none;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all var(--transition-normal);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        .login-button.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .login-footer {
            padding: var(--space-6);
            background: var(--bg-secondary);
            text-align: center;
            border-top: 1px solid var(--border-light);
        }
        
        .register-link {
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
        }
        
        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: var(--font-medium);
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        /* ===== LOGOUT MESSAGE ===== */
        .logout-message {
            background: var(--success-light);
            border: 1px solid var(--success);
            color: #065f46;
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-3);
            animation: slideInDown 0.5s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }
            
            .login-header,
            .login-body,
            .login-footer {
                padding-left: var(--space-4);
                padding-right: var(--space-4);
            }
            
            .login-title {
                font-size: var(--font-size-xl);
            }
        }
        
        /* ===== ANIMATIONS ===== */
        .login-card {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-logo">
                    <i class="material-icons">inventory_2</i>
                </div>
                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your Warehouse Pro account</p>
            </div>
            
            <!-- Body -->
            <div class="login-body">
                <?php if(isset($_GET['logout'])): ?>
                    <div class="logout-message">
                        <i class="material-icons">check_circle</i>
                        <span>You have been successfully logged out!</span>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="login_check.php" id="loginForm">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="form-input-group">
                            <input type="text" name="username" id="username" class="form-input" 
                                   placeholder="Enter your username" required>
                            <i class="material-icons form-input-icon">person</i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="form-input-group">
                            <input type="password" name="password" id="password" class="form-input" 
                                   placeholder="Enter your password" required>
                            <i class="material-icons form-input-icon">lock</i>
                        </div>
                    </div>
                    
                    <div class="remember-group">
                        <input type="checkbox" name="remember" id="remember" class="checkbox">
                        <label for="remember" class="checkbox-label">Remember me</label>
                    </div>
                    
                    <button type="submit" class="login-button" id="loginButton">
                        <span>Sign In</span>
                        <i class="material-icons">arrow_forward</i>
                    </button>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="login-footer">
                <p class="register-link">
                    Don't have an account? <a href="regestration.php">Create one here</a>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const inputs = form.querySelectorAll('input[required]');
            
            // Form validation
            function validateForm() {
                let isValid = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = 'var(--error)';
                    } else {
                        input.style.borderColor = 'var(--border-light)';
                    }
                });
                return isValid;
            }
            
            // Real-time validation
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.style.borderColor = 'var(--success)';
                    } else {
                        this.style.borderColor = 'var(--border-light)';
                    }
                });
                
                input.addEventListener('focus', function() {
                    this.style.borderColor = 'var(--primary)';
                });
                
                input.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.style.borderColor = 'var(--border-light)';
                    }
                });
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return;
                }
                
                // Show loading state
                button.classList.add('loading');
                button.innerHTML = '<span>Signing In...</span>';
                button.disabled = true;
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.ctrlKey) {
                    form.dispatchEvent(new Event('submit'));
                }
            });
            
            // Auto-hide logout message
            const logoutMessage = document.querySelector('.logout-message');
            if (logoutMessage) {
                setTimeout(() => {
                    logoutMessage.style.opacity = '0';
                    logoutMessage.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        logoutMessage.remove();
                    }, 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>
