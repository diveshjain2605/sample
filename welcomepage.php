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

    // Enhanced hover effects for cards
    const cards = document.querySelectorAll('.card.hoverable');
    cards.forEach((card, index) => {
        // Initial animation
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);

        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 15px 40px rgba(108, 92, 231, 0.2)';
            this.style.transition = 'all 0.3s ease';

            // Add glow effect to icon
            const icon = this.querySelector('.material-icons.large');
            if (icon) {
                icon.style.textShadow = '0 0 20px var(--accent-light)';
                icon.style.transform = 'scale(1.1)';
            }
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';

            const icon = this.querySelector('.material-icons.large');
            if (icon) {
                icon.style.textShadow = '';
                icon.style.transform = 'scale(1)';
            }
        });
    });

    // Enhanced stats animation with counter effect
    const statNumbers = document.querySelectorAll('.card h4');
    const statValues = ['25', '142', '18', '₹2.4L']; // Sample values

    statNumbers.forEach((stat, index) => {
        stat.textContent = '0';
        stat.style.opacity = '0';
        stat.style.transform = 'scale(0.5)';

        setTimeout(() => {
            stat.style.transition = 'all 0.5s ease';
            stat.style.opacity = '1';
            stat.style.transform = 'scale(1)';

            // Counter animation
            if (index < statValues.length) {
                animateCounter(stat, statValues[index], 1500);
            }
        }, 1000 + (index * 300));
    });

    // Counter animation function
    function animateCounter(element, target, duration) {
        const isNumber = !isNaN(target);
        const targetNum = isNumber ? parseInt(target) : parseInt(target.replace(/[^\d]/g, ''));
        const increment = targetNum / (duration / 50);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= targetNum) {
                current = targetNum;
                clearInterval(timer);
            }

            if (target.includes('₹')) {
                element.textContent = '₹' + Math.floor(current / 100000) + '.' + Math.floor((current % 100000) / 10000) + 'L';
            } else {
                element.textContent = Math.floor(current).toString();
            }
        }, 50);
    }

    // Add floating animation to welcome header
    const welcomeCard = document.querySelector('.card[style*="linear-gradient"]');
    if (welcomeCard) {
        welcomeCard.style.animation = 'float 6s ease-in-out infinite';
    }

    // Add particle effect on navigation hover
    const navLinks = document.querySelectorAll('nav a');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            createMiniParticles(this);
        });
    });

    function createMiniParticles(element) {
        for (let i = 0; i < 5; i++) {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: var(--accent-light);
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                opacity: 0.8;
            `;

            const rect = element.getBoundingClientRect();
            particle.style.left = (rect.left + Math.random() * rect.width) + 'px';
            particle.style.top = (rect.top + Math.random() * rect.height) + 'px';

            document.body.appendChild(particle);

            // Animate particle
            particle.animate([
                { transform: 'translateY(0px)', opacity: 0.8 },
                { transform: 'translateY(-30px)', opacity: 0 }
            ], {
                duration: 1000,
                easing: 'ease-out'
            }).onfinish = () => particle.remove();
        }
    }

    // Add CSS for float animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    `;
    document.head.appendChild(style);
});
</script>
