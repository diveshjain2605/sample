<?php
/**
 * Update Include Paths After Reorganization
 * This script updates all include/require paths in the reorganized files
 */

echo "🔧 Updating include paths in reorganized files...\n\n";

// Define path mappings for different file locations
$path_mappings = [
    // For files in pages/auth/ (2 levels deep)
    'pages/auth/' => [
        "include('conn.php')" => "include('../../config/conn.php')",
        "include('session.php')" => "include('../../config/session.php')",
        "include('header.php')" => "include('../../core/includes/header.php')",
        "include('footer.php')" => "include('../../core/includes/footer.php')",
        "include('simple_header.php')" => "include('../../core/includes/header.php')",
        "include('simple_footer.php')" => "include('../../core/includes/footer.php')",
        'action="login_check.php"' => 'action="../../core/auth/login_check.php"',
        'action="regestrationformsubmit.php"' => 'action="../../core/auth/registration_submit.php"',
        'href="welcomepage.php"' => 'href="../dashboard/index.php"',
        'href="simple_welcomepage.php"' => 'href="../dashboard/index.php"'
    ],
    
    // For files in pages/dashboard/ (2 levels deep)
    'pages/dashboard/' => [
        "include('conn.php')" => "include('../../config/conn.php')",
        "include('session.php')" => "include('../../config/session.php')",
        "include('header.php')" => "include('../../core/includes/header.php')",
        "include('footer.php')" => "include('../../core/includes/footer.php')",
        "include('simple_header.php')" => "include('../../core/includes/header.php')",
        "include('simple_footer.php')" => "include('../../core/includes/footer.php')",
        'href="table.php"' => 'href="../users/index.php"',
        'href="Form.php"' => 'href="../users/add.php"',
        'href="invoice.php"' => 'href="../invoices/create.php"',
        'href="invoicelist.php"' => 'href="../invoices/index.php"'
    ],
    
    // For files in pages/users/ (2 levels deep)
    'pages/users/' => [
        "include('conn.php')" => "include('../../config/conn.php')",
        "include('session.php')" => "include('../../config/session.php')",
        "include('header.php')" => "include('../../core/includes/header.php')",
        "include('footer.php')" => "include('../../core/includes/footer.php')",
        "include('simple_header.php')" => "include('../../core/includes/header.php')",
        "include('simple_footer.php')" => "include('../../core/includes/footer.php')",
        'href="welcomepage.php"' => 'href="../dashboard/index.php"',
        'href="simple_welcomepage.php"' => 'href="../dashboard/index.php"'
    ],
    
    // For files in pages/invoices/ (2 levels deep)
    'pages/invoices/' => [
        "include('conn.php')" => "include('../../config/conn.php')",
        "include('session.php')" => "include('../../config/session.php')",
        "include('header.php')" => "include('../../core/includes/header.php')",
        "include('footer.php')" => "include('../../core/includes/footer.php')",
        "include('simple_header.php')" => "include('../../core/includes/header.php')",
        "include('simple_footer.php')" => "include('../../core/includes/footer.php')",
        'href="welcomepage.php"' => 'href="../dashboard/index.php"',
        'href="simple_welcomepage.php"' => 'href="../dashboard/index.php"',
        'href="invoicelist.php"' => 'href="index.php"',
        'href="invoice.php"' => 'href="create.php"'
    ],
    
    // For files in core/auth/ (2 levels deep)
    'core/auth/' => [
        "include('conn.php')" => "include('../../config/conn.php')",
        "include('session.php')" => "include('../../config/session.php')",
        'header("Location: welcomepage.php")' => 'header("Location: ../../pages/dashboard/index.php")',
        'header("Location: index.php")' => 'header("Location: ../../pages/auth/index.php")'
    ],
    
    // For files in core/includes/ (2 levels deep)
    'core/includes/' => [
        'href="welcomepage.php"' => 'href="../../pages/dashboard/index.php"',
        'href="table.php"' => 'href="../../pages/users/index.php"',
        'href="Form.php"' => 'href="../../pages/users/add.php"',
        'href="invoice.php"' => 'href="../../pages/invoices/create.php"',
        'href="invoicelist.php"' => 'href="../../pages/invoices/index.php"',
        'href="profile.php"' => 'href="../../pages/users/profile.php"',
        'href="change_password.php"' => 'href="../../pages/users/change_password.php"',
        'href="logout.php"' => 'href="../auth/logout.php"',
        'href="simple_design_system.css"' => 'href="../../assets/css/main.css"',
        'href="ui_fixes.css"' => 'href="../../assets/css/fixes.css"',
        'src="ui_enhancements.js"' => 'src="../../assets/js/enhancements.js"'
    ]
];

// Function to update file paths
function updateFilePaths($directory, $mappings) {
    if (!is_dir($directory)) {
        echo "❌ Directory not found: $directory\n";
        return;
    }
    
    $files = glob($directory . '*.php');
    
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $original_content = $content;
        
        foreach ($mappings as $old_path => $new_path) {
            $content = str_replace($old_path, $new_path, $content);
        }
        
        if ($content !== $original_content) {
            file_put_contents($file, $content);
            echo "✅ Updated paths in: " . basename($file) . "\n";
        }
    }
}

// Update paths in all directories
foreach ($path_mappings as $directory => $mappings) {
    echo "📁 Updating files in: $directory\n";
    updateFilePaths($directory, $mappings);
    echo "\n";
}

// Update asset references in CSS files
echo "🎨 Updating asset references...\n";
$css_files = glob('assets/css/*.css');
foreach ($css_files as $css_file) {
    $content = file_get_contents($css_file);
    $original_content = $content;
    
    // Update any relative paths in CSS
    $content = str_replace('url("../', 'url("../../', $content);
    
    if ($content !== $original_content) {
        file_put_contents($css_file, $content);
        echo "✅ Updated asset paths in: " . basename($css_file) . "\n";
    }
}

// Create a quick navigation helper
$nav_helper = '<?php
/**
 * Navigation Helper - Quick path references
 */

// Base paths
define("BASE_PATH", "../../");
define("CONFIG_PATH", BASE_PATH . "config/");
define("CORE_PATH", BASE_PATH . "core/");
define("PAGES_PATH", BASE_PATH . "pages/");
define("ASSETS_PATH", BASE_PATH . "assets/");

// Quick includes
function includeConfig($file) {
    include(CONFIG_PATH . $file);
}

function includeCore($file) {
    include(CORE_PATH . $file);
}

// Quick redirects
function redirectTo($page) {
    header("Location: " . PAGES_PATH . $page);
    exit();
}

function redirectToAuth() {
    header("Location: " . PAGES_PATH . "auth/index.php");
    exit();
}

function redirectToDashboard() {
    header("Location: " . PAGES_PATH . "dashboard/index.php");
    exit();
}
?>';

file_put_contents('core/includes/nav_helper.php', $nav_helper);
echo "✅ Created navigation helper\n";

// Create updated main index with better structure
$main_index = '<?php
/**
 * Warehouse Pro - Main Entry Point
 * Professional warehouse management system
 */

// Check if user is already logged in
session_start();
if (isset($_SESSION["user_name"])) {
    header("Location: pages/dashboard/index.php");
    exit();
}

// Redirect to login page
header("Location: pages/auth/index.php");
exit();
?>';

file_put_contents('index.php', $main_index);
echo "✅ Updated main index.php\n";

echo "\n🎉 Path updates completed!\n";
echo "\n📋 Summary of updates:\n";
echo "✅ Updated include paths in all PHP files\n";
echo "✅ Updated href/action attributes\n";
echo "✅ Updated asset references\n";
echo "✅ Created navigation helper\n";
echo "✅ Updated main index.php\n";

echo "\n🔗 New URL Structure:\n";
echo "Main Site: /index.php (redirects to login)\n";
echo "Login: /pages/auth/index.php\n";
echo "Dashboard: /pages/dashboard/index.php\n";
echo "Users: /pages/users/index.php\n";
echo "Invoices: /pages/invoices/index.php\n";

echo "\n✅ Your project is now fully organized and paths are updated!\n";
?>
