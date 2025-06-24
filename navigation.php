
<?php
// Get current page for active navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);

// Define navigation items
$nav_items = [
    'welcomepage.php' => [
        'title' => 'Dashboard',
        'icon' => 'dashboard',
        'description' => 'Main dashboard overview'
    ],
    'table.php' => [
        'title' => 'Users',
        'icon' => 'people',
        'description' => 'Manage system users'
    ],
    'Form.php' => [
        'title' => 'Customers',
        'icon' => 'contacts',
        'description' => 'Customer management'
    ],
    'invoice.php' => [
        'title' => 'New Invoice',
        'icon' => 'add_box',
        'description' => 'Create new invoice'
    ],
    'invoicelist.php' => [
        'title' => 'Invoices',
        'icon' => 'receipt_long',
        'description' => 'View all invoices'
    ]
];

// Get page title based on current page
function getPageTitle($current_page, $nav_items) {
    if (isset($nav_items[$current_page])) {
        return $nav_items[$current_page]['title'];
    }
    
    // Special cases
    switch($current_page) {
        case 'itemlist.php':
            return 'Invoice Details';
        case 'profile.php':
            return 'Profile';
        case 'change_password.php':
            return 'Change Password';
        default:
            return 'Warehouse Pro';
    }
}

$page_title = getPageTitle($current_page, $nav_items);
?>

<nav class="nav-main">
    <div class="nav-wrapper">
        <a href="welcomepage.php" class="brand-logo">
            <i class="material-icons left">inventory</i>
            <span class="brand-text">Warehouse Pro</span>
        </a>
        
        <!-- Desktop Navigation -->
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <?php foreach($nav_items as $page => $item): ?>
                <li class="<?php echo ($current_page == $page) ? 'active' : ''; ?>">
                    <a href="<?php echo $page; ?>" class="nav-link tooltipped" 
                       data-tooltip="<?php echo $item['description']; ?>" data-position="bottom">
                        <i class="material-icons left"><?php echo $item['icon']; ?></i>
                        <?php echo $item['title']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            
            <!-- User Dropdown -->
            <li>
                <a class="dropdown-trigger" href="#" data-target="user-dropdown">
                    <i class="material-icons left">account_circle</i>
                    <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?>
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        </ul>
        
        <!-- Mobile Menu Trigger -->
        <a href="#" data-target="mobile-nav" class="sidenav-trigger">
            <i class="material-icons">menu</i>
        </a>
    </div>
</nav>

<!-- User Dropdown Structure -->
<ul id="user-dropdown" class="dropdown-content">
    <li><a href="profile.php"><i class="material-icons left">person</i>Profile</a></li>
    <li><a href="change_password.php"><i class="material-icons left">lock</i>Change Password</a></li>
    <li class="divider"></li>
    <li><a href="logout.php"><i class="material-icons left">logout</i>Logout</a></li>
</ul>

<!-- Mobile Navigation -->
<ul class="sidenav" id="mobile-nav">
    <li>
        <div class="user-view">
            <div class="background" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));"></div>
            <a href="#user"><i class="material-icons circle white-text">account_circle</i></a>
            <a href="#name"><span class="white-text name"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?></span></a>
            <a href="#email"><span class="white-text email"><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'user@warehouse.com'; ?></span></a>
        </div>
    </li>
    
    <?php foreach($nav_items as $page => $item): ?>
        <li class="<?php echo ($current_page == $page) ? 'active' : ''; ?>">
            <a href="<?php echo $page; ?>">
                <i class="material-icons"><?php echo $item['icon']; ?></i>
                <?php echo $item['title']; ?>
            </a>
        </li>
    <?php endforeach; ?>
    
    <li><div class="divider"></div></li>
    <li><a href="profile.php"><i class="material-icons">person</i>Profile</a></li>
    <li><a href="change_password.php"><i class="material-icons">lock</i>Change Password</a></li>
    <li><a href="logout.php"><i class="material-icons">logout</i>Logout</a></li>
</ul>

<!-- Breadcrumb Navigation -->
<div class="breadcrumb-container">
    <div class="container">
        <nav class="breadcrumb-nav">
            <div class="nav-wrapper transparent">
                <div class="col s12">
                    <a href="welcomepage.php" class="breadcrumb">
                        <i class="material-icons left tiny">home</i>Home
                    </a>
                    <?php if($current_page != 'welcomepage.php'): ?>
                        <a href="#" class="breadcrumb active">
                            <?php echo $page_title; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</div>

<style>
.nav-main {
    background: var(--nav-bg) !important;
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--glass-border);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    z-index: 1000;
    width: 100%;
}

.nav-main .brand-logo {
    color: var(--accent-light) !important;
    font-weight: 600;
    text-shadow: 0 0 10px rgba(108, 92, 231, 0.3);
    padding-left: 20px;
}

.brand-text {
    font-size: 1.5rem;
}

.nav-main ul a {
    color: var(--text-primary) !important;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 0 5px;
    position: relative;
}

.nav-main ul a:hover {
    background: var(--glass-bg) !important;
    color: var(--accent-light) !important;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 25px rgba(108, 92, 231, 0.3);
    border-radius: 12px;
}

.nav-main ul li.active a {
    background: var(--accent-purple) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
}

.nav-main ul li.active a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid var(--accent-purple);
}

.breadcrumb-container {
    margin-top: 64px;
    background: rgba(26, 26, 46, 0.5);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--glass-border);
}

.breadcrumb-nav .breadcrumb {
    color: var(--text-secondary) !important;
    font-size: 14px;
    transition: all 0.3s ease;
}

.breadcrumb-nav .breadcrumb:hover {
    color: var(--accent-light) !important;
}

.breadcrumb-nav .breadcrumb.active {
    color: var(--accent-light) !important;
    font-weight: 500;
}

.breadcrumb-nav .breadcrumb:before {
    color: var(--text-secondary);
}

/* Dropdown Styles */
.dropdown-content {
    background: var(--card-bg) !important;
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin-top: 10px;
}

.dropdown-content li > a {
    color: var(--text-primary) !important;
    transition: all 0.3s ease;
    padding: 12px 16px;
}

.dropdown-content li:hover {
    background: var(--glass-bg) !important;
}

.dropdown-content .divider {
    background-color: var(--glass-border);
}

/* Sidenav Styles */
.sidenav {
    background: var(--card-bg) !important;
    backdrop-filter: blur(20px);
    border-right: 1px solid var(--glass-border);
}

.sidenav li > a {
    color: var(--text-primary) !important;
    transition: all 0.3s ease;
}

.sidenav li:hover > a {
    background: var(--glass-bg) !important;
    color: var(--accent-light) !important;
}

.sidenav li.active > a {
    background: var(--accent-purple) !important;
    color: white !important;
}

.sidenav .user-view .name,
.sidenav .user-view .email {
    color: white !important;
}

/* Mobile Responsive */
@media only screen and (max-width: 992px) {
    .brand-text {
        display: none;
    }
    
    .nav-main .brand-logo {
        font-size: 1.8rem;
    }
}

/* Page Content Margin */
body {
    padding-top: 64px;
}

.breadcrumb-container + .container,
.breadcrumb-container + div {
    margin-top: 20px;
}
</style>

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
    
    // Initialize tooltips
    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);
    
    // Add active page highlighting
    const currentPage = '<?php echo $current_page; ?>';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.parentElement.classList.add('active');
        }
    });
});
</script>


