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
                    <i class="material-icons large">person_add</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">Customer Registration</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Add new customer information to the system</p>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="customer_submit.php" enctype="multipart/form-data" id="customerForm">
        <div class="row">
            <!-- Personal Information Card -->
            <div class="col s12 l6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">
                            <i class="material-icons left" style="color: var(--accent-light);">person</i>
                            Personal Information
                        </span>
                        <div class="divider" style="margin: 15px 0;"></div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="fname" id="fname" required>
                                <label for="fname">First Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="lname" id="lname" required>
                                <label for="lname">Last Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">cake</i>
                                <input type="date" name="dob" id="dob" required>
                                <label for="dob">Date of Birth</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">phone</i>
                                <input type="tel" name="mobile" id="mobile" required>
                                <label for="mobile">Mobile Number</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" required>
                                <label for="email">Email Address</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">bloodtype</i>
                                <select name="blood_group" id="blood_group">
                                    <option value="" disabled selected>Choose Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                                <label>Blood Group</label>
                            </div>
                            <div class="col s12" style="margin: 20px 0;">
                                <label style="color: var(--text-primary); font-size: 16px;">
                                    <i class="material-icons left">wc</i>Gender:
                                </label>
                                <p style="margin-top: 10px;">
                                    <label>
                                        <input name="gender" type="radio" value="male" required />
                                        <span>Male</span>
                                    </label>
                                    <label style="margin-left: 30px;">
                                        <input name="gender" type="radio" value="female" required />
                                        <span>Female</span>
                                    </label>
                                    <label style="margin-left: 30px;">
                                        <input name="gender" type="radio" value="other" required />
                                        <span>Other</span>
                                    </label>
                                </p>
                            </div>
                            <div class="file-field input-field col s12">
                                <div class="btn">
                                    <span><i class="material-icons left">photo_camera</i>Photo</span>
                                    <input type="file" name="photo" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload your photo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="col s12 l6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">
                            <i class="material-icons left" style="color: var(--accent-light);">location_on</i>
                            Contact Information
                        </span>
                        <div class="divider" style="margin: 15px 0;"></div>

                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">home</i>
                                <textarea name="address" id="address" class="materialize-textarea" required></textarea>
                                <label for="address">Address</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">place</i>
                                <input type="text" name="landmark" id="landmark">
                                <label for="landmark">Landmark</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">location_city</i>
                                <input type="text" name="city" id="city" required>
                                <label for="city">City</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">map</i>
                                <input type="text" name="state" id="state" required>
                                <label for="state">State</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">markunread_mailbox</i>
                                <input type="number" name="pincode" id="pincode" required>
                                <label for="pincode">Pincode</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">public</i>
                                <select name="country" id="country" required>
                                    <option value="" disabled selected>Choose Country</option>
                                    <option value="India">India</option>
                                    <option value="USA">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Canada">Canada</option>
                                </select>
                                <label>Country</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">
                            <i class="material-icons left" style="color: var(--accent-light);">info</i>
                            Additional Information
                        </span>
                        <div class="divider" style="margin: 15px 0;"></div>

                        <div class="row">
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">height</i>
                                <input type="number" name="height" id="height" step="0.1">
                                <label for="height">Height (cm)</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">fitness_center</i>
                                <input type="number" name="weight" id="weight" step="0.1">
                                <label for="weight">Weight (kg)</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">work</i>
                                <input type="text" name="occupation" id="occupation">
                                <label for="occupation">Occupation</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">note</i>
                                <textarea name="notes" id="notes" class="materialize-textarea"></textarea>
                                <label for="notes">Additional Notes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms and Submit -->
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <label>
                                    <input type="checkbox" name="terms" id="terms" required />
                                    <span>I agree to the <a href="#" style="color: var(--accent-light);">Terms and Conditions</a> and <a href="#" style="color: var(--accent-light);">Privacy Policy</a></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action center-align">
                        <div class="btn-group">
                            <button type="button" class="btn-large waves-effect waves-light btn-secondary">
                                <i class="material-icons left">clear</i>Reset Form
                            </button>
                            <button type="submit" class="btn-large waves-effect waves-light">
                                <i class="material-icons left">person_add</i>Add Customer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
.card.hoverable:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2) !important;
}

.form-section {
    margin-bottom: 30px;
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

.radio-group {
    margin: 20px 0;
}

.radio-group label {
    margin-right: 20px;
}

[type="radio"]:checked + span:after {
    background-color: var(--accent-light);
    border-color: var(--accent-light);
}

[type="checkbox"]:checked + span:not(.lever):before {
    border-color: var(--accent-light);
    background-color: var(--accent-light);
}

.file-field .btn {
    background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));
}

.file-field .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
}

.form-validation-error {
    border-bottom: 2px solid #f44336 !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Materialize components
    var selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs);

    var textareas = document.querySelectorAll('textarea');
    M.textareaAutoResize(textareas);

    // Form validation
    const form = document.getElementById('customerForm');
    const inputs = form.querySelectorAll('input[required], select[required]');

    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('form-validation-error')) {
                validateField(this);
            }
        });
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        if (isValid) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="material-icons left">hourglass_empty</i>Adding Customer...';
            submitBtn.disabled = true;

            // Simulate form submission (replace with actual submission)
            setTimeout(() => {
                M.toast({html: 'Customer added successfully!', classes: 'green'});
                form.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Reinitialize selects after reset
                M.FormSelect.init(selects);
            }, 2000);
        } else {
            M.toast({html: 'Please fill in all required fields correctly', classes: 'red'});
        }
    });

    // Reset button functionality
    const resetBtn = form.querySelector('button[type="button"]');
    resetBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            form.reset();
            M.FormSelect.init(selects);
            M.toast({html: 'Form reset successfully', classes: 'orange'});
        }
    });

    function validateField(field) {
        const value = field.value.trim();
        let isValid = true;

        // Remove existing error class
        field.classList.remove('form-validation-error');

        if (field.hasAttribute('required') && !value) {
            isValid = false;
        } else if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
            }
        } else if (field.type === 'tel' && value) {
            const phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(value.replace(/\D/g, ''))) {
                isValid = false;
            }
        }

        if (!isValid) {
            field.classList.add('form-validation-error');
        }

        return isValid;
    }

    // Animate cards on load
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>

<?php include('footer.php'); ?>