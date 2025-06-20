<?php
include('session.php');
if (!(isset($_SESSION['user_name']))) {
    header('Location: index.php');
    exit();
}
include('header.php');
?>

<nav>
    <div class="nav-wrapper">
        <a href="#" class="brand-logo"><i class="material-icons left">dashboard</i>Warehouse Pro</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="welcomepage.php"><i class="material-icons left">home</i>Dashboard</a></li>
            <li><a href="Form.php"><i class="material-icons left">contacts</i>Customers</a></li>
            <li><a href="invoicelist.php"><i class="material-icons left">receipt_long</i>Invoices</a></li>
            <li><a href="logout.php"><i class="material-icons left">logout</i>Logout</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1">
                <i class="material-icons left">account_circle</i><?php echo $_SESSION['user_name']; ?><i class="material-icons right">arrow_drop_down</i>
            </a></li>
        </ul>
        <!-- Mobile menu trigger -->
        <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
</nav>

<!-- Mobile Navigation -->
<ul class="sidenav" id="mobile-nav">
    <li><div class="user-view">
        <div class="background" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));"></div>
        <a href="#user"><i class="material-icons circle">account_circle</i></a>
        <a href="#name"><span class="white-text name"><?php echo $_SESSION['user_name']; ?></span></a>
    </div></li>
    <li><a href="welcomepage.php"><i class="material-icons">home</i>Dashboard</a></li>
    <li><a href="Form.php"><i class="material-icons">contacts</i>Customers</a></li>
    <li><a href="invoicelist.php"><i class="material-icons">receipt_long</i>Invoices</a></li>
    <li><div class="divider"></div></li>
    <li><a href="profile.php"><i class="material-icons">person</i>Profile</a></li>
    <li><a href="change_password.php"><i class="material-icons">lock</i>Change Password</a></li>
    <li><a href="logout.php"><i class="material-icons">logout</i>Logout</a></li>
</ul>

<ul id="dropdown1" class="dropdown-content">
    <li><a href="profile.php">Profile</a></li>
    <li><a href="change_password.php">Change Password</a></li>
    <li class="divider"></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<!-- Welcome Header -->
<div class="container">
    <div class="row" style="margin-top: 40px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">dashboard</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">Welcome back, <?php echo $_SESSION['user_name']; ?>!</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Manage your business operations efficiently</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4">
                            <i class="material-icons large" style="color: var(--accent-light);">people</i>
                        </div>
                        <div class="col s8">
                            <span class="card-title">User Management</span>
                            <p>Manage registered users and their permissions</p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <a href="table.php"><i class="material-icons left">visibility</i>View Users</a>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4">
                            <i class="material-icons large" style="color: var(--accent-light);">receipt_long</i>
                        </div>
                        <div class="col s8">
                            <span class="card-title">Invoice System</span>
                            <p>Create, manage and track customer invoices</p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <a href="invoice.php"><i class="material-icons left">add</i>Create Invoice</a>
                    <a href="invoicelist.php"><i class="material-icons left">list</i>View All</a>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l4">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4">
                            <i class="material-icons large" style="color: var(--accent-light);">contacts</i>
                        </div>
                        <div class="col s8">
                            <span class="card-title">Customer Portal</span>
                            <p>Manage customer information and relationships</p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <a href="Form.php"><i class="material-icons left">person_add</i>Add Customer</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row">
        <div class="col s12">
            <h5 style="color: var(--accent-light); margin: 30px 0 20px 0;">
                <i class="material-icons left">analytics</i>Quick Overview
            </h5>
        </div>
        <div class="col s12 m3">
            <div class="card center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">group</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">--</h4>
                    <p>Total Users</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">receipt</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">--</h4>
                    <p>Total Invoices</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">trending_up</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">--</h4>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">account_balance_wallet</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">--</h4>
                    <p>Revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dropdown
    var dropdowns = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(dropdowns, {
        coverTrigger: false,
        constrainWidth: false,
        hover: false,
        alignment: 'right'
    });

    // Initialize sidenav
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs, {
        edge: 'left',
        draggable: true
    });

    // Add hover effects to cards
    const cards = document.querySelectorAll('.card.hoverable');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'all 0.3s ease';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animate stats on load
    const statNumbers = document.querySelectorAll('.card h4');
    statNumbers.forEach((stat, index) => {
        setTimeout(() => {
            stat.style.opacity = '0';
            stat.style.transform = 'scale(0.5)';
            setTimeout(() => {
                stat.style.transition = 'all 0.5s ease';
                stat.style.opacity = '1';
                stat.style.transform = 'scale(1)';
            }, 100);
        }, index * 200);
    });
});
</script>
