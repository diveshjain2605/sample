<?php
include('session.php');
include('header.php');
include('navigation.php');
?>

<div class="container">
    <!-- Header Section -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">lock</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">Change Password</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Update your account password for security</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">security</i>
                        Password Security
                    </span>
                    <div class="divider" style="margin: 15px 0;"></div>

                    <form id="passwordForm" method="post" action="update_password.php">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input type="password" name="current_password" id="current_password" required>
                                <label for="current_password">Current Password</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="new_password" id="new_password" required>
                                <label for="new_password">New Password</label>
                                <span class="helper-text" data-error="Password must be at least 6 characters" data-success="Strong password">
                                    Password must be at least 6 characters long
                                </span>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="confirm_password" id="confirm_password" required>
                                <label for="confirm_password">Confirm New Password</label>
                                <span class="helper-text" data-error="Passwords do not match" data-success="Passwords match">
                                    Re-enter your new password
                                </span>
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="password-strength" style="margin: 20px 0;">
                            <p style="margin-bottom: 10px; color: var(--text-secondary);">Password Strength:</p>
                            <div class="progress" style="background: rgba(255,255,255,0.1);">
                                <div class="determinate" id="strength-bar" style="width: 0%; background: #f44336;"></div>
                            </div>
                            <p id="strength-text" style="margin-top: 5px; font-size: 14px; color: var(--text-secondary);">Enter a password</p>
                        </div>

                        <!-- Security Tips -->
                        <div class="security-tips" style="background: var(--glass-bg); padding: 15px; border-radius: 8px; margin: 20px 0;">
                            <h6 style="color: var(--accent-light); margin-bottom: 10px;">
                                <i class="material-icons left tiny">tips_and_updates</i>Security Tips
                            </h6>
                            <ul style="margin: 0; padding-left: 20px;">
                                <li style="color: var(--text-secondary); font-size: 14px; margin: 5px 0;">Use at least 8 characters</li>
                                <li style="color: var(--text-secondary); font-size: 14px; margin: 5px 0;">Include uppercase and lowercase letters</li>
                                <li style="color: var(--text-secondary); font-size: 14px; margin: 5px 0;">Add numbers and special characters</li>
                                <li style="color: var(--text-secondary); font-size: 14px; margin: 5px 0;">Avoid common words or personal information</li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="profile.php" class="btn waves-effect waves-light btn-secondary">
                        <i class="material-icons left">arrow_back</i>Back to Profile
                    </a>
                    <button type="submit" form="passwordForm" class="btn waves-effect waves-light right">
                        <i class="material-icons left">save</i>Update Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.password-strength .progress {
    height: 8px;
    border-radius: 4px;
}

.security-tips ul li::marker {
    color: var(--accent-light);
}

.input-field input:focus + label {
    color: var(--accent-light) !important;
}

.input-field input:focus {
    border-bottom: 2px solid var(--accent-light) !important;
    box-shadow: 0 1px 0 0 var(--accent-light) !important;
}

.input-field .prefix.active {
    color: var(--accent-light) !important;
}

.helper-text {
    color: var(--text-secondary) !important;
}

.input-field input.valid {
    border-bottom: 2px solid #4CAF50 !important;
    box-shadow: 0 1px 0 0 #4CAF50 !important;
}

.input-field input.invalid {
    border-bottom: 2px solid #f44336 !important;
    box-shadow: 0 1px 0 0 #f44336 !important;
}

.card.hoverable:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    const form = document.getElementById('passwordForm');

    // Password strength checker
    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updateStrengthIndicator(strength);
        validatePasswordMatch();
    });

    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    function calculatePasswordStrength(password) {
        let score = 0;
        let feedback = [];

        if (password.length >= 8) score += 25;
        else feedback.push('At least 8 characters');

        if (/[a-z]/.test(password)) score += 25;
        else feedback.push('Lowercase letter');

        if (/[A-Z]/.test(password)) score += 25;
        else feedback.push('Uppercase letter');

        if (/[0-9]/.test(password)) score += 12.5;
        else feedback.push('Number');

        if (/[^A-Za-z0-9]/.test(password)) score += 12.5;
        else feedback.push('Special character');

        return { score, feedback };
    }

    function updateStrengthIndicator(strength) {
        const { score, feedback } = strength;

        strengthBar.style.width = score + '%';

        if (score < 25) {
            strengthBar.style.background = '#f44336';
            strengthText.textContent = 'Weak - Add: ' + feedback.join(', ');
            strengthText.style.color = '#f44336';
        } else if (score < 50) {
            strengthBar.style.background = '#ff9800';
            strengthText.textContent = 'Fair - Add: ' + feedback.join(', ');
            strengthText.style.color = '#ff9800';
        } else if (score < 75) {
            strengthBar.style.background = '#2196F3';
            strengthText.textContent = 'Good - Add: ' + feedback.join(', ');
            strengthText.style.color = '#2196F3';
        } else {
            strengthBar.style.background = '#4CAF50';
            strengthText.textContent = 'Strong password';
            strengthText.style.color = '#4CAF50';
        }
    }

    function validatePasswordMatch() {
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (confirmPassword && newPassword !== confirmPassword) {
            confirmPasswordInput.classList.add('invalid');
            confirmPasswordInput.classList.remove('valid');
        } else if (confirmPassword) {
            confirmPasswordInput.classList.add('valid');
            confirmPasswordInput.classList.remove('invalid');
        }
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (newPassword.length < 6) {
            M.toast({html: 'Password must be at least 6 characters long', classes: 'red'});
            return;
        }

        if (newPassword !== confirmPassword) {
            M.toast({html: 'Passwords do not match', classes: 'red'});
            return;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="material-icons left">hourglass_empty</i>Updating...';
        submitBtn.disabled = true;

        // Simulate password update (replace with actual form submission)
        setTimeout(() => {
            M.toast({html: 'Password updated successfully!', classes: 'green'});
            form.reset();
            strengthBar.style.width = '0%';
            strengthText.textContent = 'Enter a password';
            strengthText.style.color = 'var(--text-secondary)';
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
});
</script>

<?php include('footer.php'); ?>