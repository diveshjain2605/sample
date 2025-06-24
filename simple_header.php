<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Warehouse Pro' : 'Warehouse Pro'; ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Simple Design System -->
    <link href="simple_design_system.css" rel="stylesheet">
    
    <style>
        /* ===== PAGE-SPECIFIC OVERRIDES ===== */
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
        }
        
        /* ===== ENHANCED NAVIGATION ===== */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: var(--font-size-xl);
            font-weight: var(--font-bold);
            color: var(--primary);
            text-decoration: none;
        }
        
        .navbar-brand .material-icons {
            font-size: 1.5rem;
        }
        
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: var(--space-1);
            list-style: none;
        }
        
        .navbar-link {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-4);
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: var(--font-medium);
            font-size: var(--font-size-sm);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }
        
        .navbar-link:hover {
            background: var(--primary-50);
            color: var(--primary);
        }
        
        .navbar-link.active {
            background: var(--primary);
            color: var(--text-inverse);
        }
        
        .navbar-link .material-icons {
            font-size: 1.125rem;
        }
        
        /* ===== USER DROPDOWN ===== */
        .user-dropdown {
            position: relative;
        }
        
        .user-trigger {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-2) var(--space-3);
            background: var(--bg-primary);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all var(--transition-fast);
        }
        
        .user-trigger:hover {
            background: var(--bg-secondary);
            border-color: var(--border-medium);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: var(--text-inverse);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-sm);
            font-weight: var(--font-semibold);
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: var(--space-2);
            background: var(--bg-primary);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            z-index: var(--z-dropdown);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all var(--transition-fast);
        }
        
        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: var(--font-size-sm);
            transition: all var(--transition-fast);
        }
        
        .dropdown-item:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .dropdown-divider {
            height: 1px;
            background: var(--border-light);
            margin: var(--space-2) 0;
        }
        
        /* ===== MOBILE MENU ===== */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            padding: var(--space-2);
            border-radius: var(--radius-md);
            transition: all var(--transition-fast);
        }
        
        .mobile-menu-toggle:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: var(--z-modal);
        }
        
        .mobile-menu-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 280px;
            height: 100%;
            background: var(--bg-primary);
            box-shadow: var(--shadow-xl);
            transform: translateX(100%);
            transition: transform var(--transition-normal);
        }
        
        .mobile-menu.show .mobile-menu-content {
            transform: translateX(0);
        }
        
        .mobile-menu-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--border-light);
        }
        
        .mobile-menu-nav {
            padding: var(--space-4);
        }
        
        .mobile-menu-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: var(--radius-md);
            margin-bottom: var(--space-2);
            transition: all var(--transition-fast);
        }
        
        .mobile-menu-link:hover,
        .mobile-menu-link.active {
            background: var(--primary-50);
            color: var(--primary);
        }
        
        /* ===== BREADCRUMB ===== */
        .breadcrumb {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-light);
            padding: var(--space-4) 0;
        }
        
        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: var(--font-size-sm);
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--text-muted);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .breadcrumb-item:hover {
            color: var(--primary);
        }
        
        .breadcrumb-item.active {
            color: var(--text-primary);
            font-weight: var(--font-medium);
        }
        
        .breadcrumb-separator {
            color: var(--text-muted);
            margin: 0 var(--space-1);
        }
        
        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .mobile-menu {
                display: block;
            }
            
            .navbar-brand span {
                display: none;
            }
        }
        
        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: var(--space-6) 0;
            min-height: calc(100vh - 140px);
        }
        
        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-container">
                <!-- Brand -->
                <a href="welcomepage.php" class="navbar-brand">
                    <i class="material-icons">inventory_2</i>
                    <span>Warehouse Pro</span>
                </a>
                
                <!-- Desktop Navigation -->
                <ul class="navbar-nav">
                    <li><a href="welcomepage.php" class="navbar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'welcomepage.php') ? 'active' : ''; ?>">
                        <i class="material-icons">dashboard</i>
                        Dashboard
                    </a></li>
                    <li><a href="table.php" class="navbar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'table.php') ? 'active' : ''; ?>">
                        <i class="material-icons">people</i>
                        Users
                    </a></li>
                    <li><a href="Form.php" class="navbar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'Form.php') ? 'active' : ''; ?>">
                        <i class="material-icons">person_add</i>
                        Add Customer
                    </a></li>
                    <li><a href="invoice.php" class="navbar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'invoice.php') ? 'active' : ''; ?>">
                        <i class="material-icons">add_box</i>
                        New Invoice
                    </a></li>
                    <li><a href="invoicelist.php" class="navbar-link <?php echo (basename($_SERVER['PHP_SELF']) == 'invoicelist.php') ? 'active' : ''; ?>">
                        <i class="material-icons">receipt_long</i>
                        Invoices
                    </a></li>
                </ul>
                
                <!-- User Dropdown -->
                <div class="user-dropdown">
                    <div class="user-trigger" onclick="toggleDropdown()">
                        <div class="user-avatar">
                            <?php echo isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : 'U'; ?>
                        </div>
                        <span><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?></span>
                        <i class="material-icons">expand_more</i>
                    </div>
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="profile.php" class="dropdown-item">
                            <i class="material-icons">person</i>
                            Profile
                        </a>
                        <a href="change_password.php" class="dropdown-item">
                            <i class="material-icons">lock</i>
                            Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="material-icons">logout</i>
                            Logout
                        </a>
                    </div>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="material-icons">menu</i>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu" onclick="closeMobileMenu(event)">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <div class="d-flex items-center justify-between">
                    <div class="navbar-brand">
                        <i class="material-icons">inventory_2</i>
                        <span>Warehouse Pro</span>
                    </div>
                    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            </div>
            <nav class="mobile-menu-nav">
                <a href="welcomepage.php" class="mobile-menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'welcomepage.php') ? 'active' : ''; ?>">
                    <i class="material-icons">dashboard</i>
                    Dashboard
                </a>
                <a href="table.php" class="mobile-menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'table.php') ? 'active' : ''; ?>">
                    <i class="material-icons">people</i>
                    Users
                </a>
                <a href="Form.php" class="mobile-menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'Form.php') ? 'active' : ''; ?>">
                    <i class="material-icons">person_add</i>
                    Add Customer
                </a>
                <a href="invoice.php" class="mobile-menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'invoice.php') ? 'active' : ''; ?>">
                    <i class="material-icons">add_box</i>
                    New Invoice
                </a>
                <a href="invoicelist.php" class="mobile-menu-link <?php echo (basename($_SERVER['PHP_SELF']) == 'invoicelist.php') ? 'active' : ''; ?>">
                    <i class="material-icons">receipt_long</i>
                    Invoices
                </a>
                <div class="dropdown-divider"></div>
                <a href="profile.php" class="mobile-menu-link">
                    <i class="material-icons">person</i>
                    Profile
                </a>
                <a href="change_password.php" class="mobile-menu-link">
                    <i class="material-icons">lock</i>
                    Change Password
                </a>
                <a href="logout.php" class="mobile-menu-link">
                    <i class="material-icons">logout</i>
                    Logout
                </a>
            </nav>
        </div>
    </div>
    
    <!-- Breadcrumb -->
    <?php if (basename($_SERVER['PHP_SELF']) != 'welcomepage.php'): ?>
    <div class="breadcrumb">
        <div class="container">
            <nav class="breadcrumb-nav">
                <a href="welcomepage.php" class="breadcrumb-item">
                    <i class="material-icons">home</i>
                    Home
                </a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-item active">
                    <?php 
                    $current_page = basename($_SERVER['PHP_SELF']);
                    switch($current_page) {
                        case 'table.php': echo 'Users'; break;
                        case 'Form.php': echo 'Add Customer'; break;
                        case 'invoice.php': echo 'New Invoice'; break;
                        case 'invoicelist.php': echo 'Invoices'; break;
                        case 'itemlist.php': echo 'Invoice Details'; break;
                        case 'profile.php': echo 'Profile'; break;
                        case 'change_password.php': echo 'Change Password'; break;
                        default: echo 'Page';
                    }
                    ?>
                </span>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <script>
        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }
        
        // Mobile menu functionality
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('show');
        }
        
        function closeMobileMenu(event) {
            if (event.target === event.currentTarget) {
                toggleMobileMenu();
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const trigger = document.querySelector('.user-trigger');
            
            if (!trigger.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });
        
        // Close mobile menu on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('mobileMenu').classList.remove('show');
            }
        });
    </script>
