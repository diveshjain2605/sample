<?php
include('session.php');
include('header.php');
include('navigation.php');
include('conn.php');

// Get user information
$user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if not set
$userQuery = "SELECT * FROM user WHERE id = $user_id";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    header('Location: welcomepage.php');
    exit();
}
?>

<div class="container">
    <!-- Header Section -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">account_circle</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">User Profile</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Manage your account information</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Profile Information -->
        <div class="col s12 l8">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">person</i>
                        Profile Information
                    </span>
                    <div class="divider" style="margin: 15px 0;"></div>

                    <form id="profileForm" method="post" action="update_profile.php">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                <label for="first_name" class="active">First Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                <label for="last_name" class="active">Last Name</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="email" class="active">Email Address</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
                                <label for="user_name" class="active">Username</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <button type="submit" form="profileForm" class="btn waves-effect waves-light">
                        <i class="material-icons left">save</i>Update Profile
                    </button>
                    <a href="change_password.php" class="btn waves-effect waves-light orange">
                        <i class="material-icons left">lock</i>Change Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Account Statistics -->
        <div class="col s12 l4">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">analytics</i>
                        Account Statistics
                    </span>
                    <div class="divider" style="margin: 15px 0;"></div>

                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $invoiceCountQuery = "SELECT COUNT(*) as count FROM invoice";
                            $invoiceCountResult = mysqli_query($conn, $invoiceCountQuery);
                            $invoiceCount = mysqli_fetch_assoc($invoiceCountResult)['count'];
                            echo $invoiceCount;
                            ?>
                        </div>
                        <div class="stat-label">Total Invoices</div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-number">
                            <?php
                            $userCountQuery = "SELECT COUNT(*) as count FROM user";
                            $userCountResult = mysqli_query($conn, $userCountQuery);
                            $userCount = mysqli_fetch_assoc($userCountResult)['count'];
                            echo $userCount;
                            ?>
                        </div>
                        <div class="stat-label">Total Users</div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-number">
                            <?php echo date('M d, Y', strtotime($user['created_at'] ?? 'now')); ?>
                        </div>
                        <div class="stat-label">Member Since</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">flash_on</i>
                        Quick Actions
                    </span>
                    <div class="divider" style="margin: 15px 0;"></div>

                    <div class="quick-actions">
                        <a href="invoice.php" class="btn-block waves-effect waves-light btn">
                            <i class="material-icons left">add</i>Create Invoice
                        </a>
                        <a href="Form.php" class="btn-block waves-effect waves-light btn">
                            <i class="material-icons left">person_add</i>Add Customer
                        </a>
                        <a href="invoicelist.php" class="btn-block waves-effect waves-light btn">
                            <i class="material-icons left">list</i>View Invoices
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-item {
    text-align: center;
    margin: 20px 0;
    padding: 15px;
    background: var(--glass-bg);
    border-radius: 10px;
    border: 1px solid var(--glass-border);
}

.stat-number {
    font-size: 2rem;
    font-weight: 600;
    color: var(--accent-light);
    margin-bottom: 5px;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.quick-actions .btn-block {
    width: 100%;
    margin: 10px 0;
    text-align: left;
}

.card.hoverable:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="material-icons left">hourglass_empty</i>Updating...';
        submitBtn.disabled = true;

        // Simulate update (replace with actual form submission)
        setTimeout(() => {
            M.toast({html: 'Profile updated successfully!', classes: 'green'});
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

    // Animate stats on load
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach((stat, index) => {
        const targetValue = stat.textContent;
        if (!isNaN(targetValue)) {
            stat.textContent = '0';
            animateCounter(stat, parseInt(targetValue), 1500);
        }
    });

    function animateCounter(element, target, duration) {
        const increment = target / (duration / 50);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toString();
        }, 50);
    }
});
</script>

<?php include('footer.php'); ?>