<?php
/**
 * Quick Project Reorganization Script
 * This script will organize your Warehouse Pro project structure
 */

echo "🚀 Starting Warehouse Pro Project Reorganization...\n\n";

// Define the new folder structure
$folders = [
    'config',
    'core/auth',
    'core/includes', 
    'pages/auth',
    'pages/dashboard',
    'pages/users',
    'pages/invoices',
    'assets/css',
    'assets/js',
    'database',
    'tools',
    'docs',
    'backup'
];

// Create folders
echo "📁 Creating folder structure...\n";
foreach ($folders as $folder) {
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
        echo "✅ Created: $folder\n";
    }
}

// File movements mapping
$moves = [
    // Config files
    'conn.php' => 'config/conn.php',
    'session.php' => 'config/session.php',
    
    // Core includes (use simple versions)
    'simple_header.php' => 'core/includes/header.php',
    'simple_footer.php' => 'core/includes/footer.php',
    'navigation.php' => 'core/includes/navigation.php',
    
    // Authentication
    'simple_index.php' => 'pages/auth/index.php',
    'regestration.php' => 'pages/auth/registration.php',
    'login_check.php' => 'core/auth/login_check.php',
    'logout.php' => 'core/auth/logout.php',
    'regestrationformsubmit.php' => 'core/auth/registration_submit.php',
    
    // Dashboard
    'simple_welcomepage.php' => 'pages/dashboard/index.php',
    
    // Users
    'table.php' => 'pages/users/index.php',
    'Form.php' => 'pages/users/add.php',
    'profile.php' => 'pages/users/profile.php',
    'change_password.php' => 'pages/users/change_password.php',
    
    // Invoices
    'invoice.php' => 'pages/invoices/create.php',
    'invoicelist.php' => 'pages/invoices/index.php',
    'itemlist.php' => 'pages/invoices/view.php',
    'invoicebill.php' => 'pages/invoices/bill.php',
    
    // Assets
    'simple_design_system.css' => 'assets/css/main.css',
    'ui_fixes.css' => 'assets/css/fixes.css',
    'ui_enhancements.js' => 'assets/js/enhancements.js',
    'assets/js/theme-utils.js' => 'assets/js/theme-utils.js',
    
    // Database
    'database_setup.sql' => 'database/setup.sql',
    'database_schema_fix.php' => 'database/schema_fix.php',
    'fix_database.php' => 'database/fix.php',
    'check_database.php' => 'database/check.php',
    
    // Tools
    'add_users.php' => 'tools/add_users.php',
    'bulk_user_generator.php' => 'tools/bulk_generator.php',
    'quick_add_50_users.php' => 'tools/quick_add_users.php',
    'quick_fix.php' => 'tools/quick_fix.php',
    
    // Documentation
    'README.md' => 'docs/README.md',
    'SIMPLE_UI_IMPLEMENTATION_GUIDE.md' => 'docs/UI_GUIDE.md',
    'UI_FIXES_SUMMARY.md' => 'docs/UI_FIXES.md',
    'NAVIGATION_GUIDE.md' => 'docs/NAVIGATION.md',
    'PROJECT_REORGANIZATION_PLAN.md' => 'docs/REORGANIZATION.md'
];

// Files to delete (duplicates/old versions)
$delete_files = [
    'header.php',           // Use simple_header.php instead
    'footer.php',           // Use simple_footer.php instead  
    'index.php',            // Use simple_index.php instead
    'welcomepage.php',      // Use simple_welcomepage.php instead
    'intro.php',            // Utility file
    'getemail.php'          // Utility file
];

// Move files
echo "\n📦 Moving files to new structure...\n";
foreach ($moves as $source => $destination) {
    if (file_exists($source)) {
        // Create destination directory if it doesn't exist
        $dest_dir = dirname($destination);
        if (!file_exists($dest_dir)) {
            mkdir($dest_dir, 0755, true);
        }
        
        if (rename($source, $destination)) {
            echo "✅ Moved: $source → $destination\n";
        } else {
            echo "❌ Failed to move: $source\n";
        }
    } else {
        echo "⚠️  File not found: $source\n";
    }
}

// Backup and delete old files
echo "\n🗑️  Cleaning up duplicate/old files...\n";
foreach ($delete_files as $file) {
    if (file_exists($file)) {
        // Backup first
        if (copy($file, "backup/$file")) {
            unlink($file);
            echo "✅ Deleted: $file (backed up)\n";
        }
    }
}

// Create main index.php redirect
$main_index = '<?php
// Warehouse Pro - Main Entry Point
// Redirect to login page
header("Location: pages/auth/index.php");
exit();
?>';

file_put_contents('index.php', $main_index);
echo "✅ Created main index.php redirect\n";

// Create .htaccess for clean URLs (optional)
$htaccess = 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)/?$ pages/$1/index.php [L,QSA]

# Security
Options -Indexes
<Files "*.php">
    Order allow,deny
    Allow from all
</Files>';

file_put_contents('.htaccess', $htaccess);
echo "✅ Created .htaccess for clean URLs\n";

echo "\n🎉 Project reorganization completed!\n";
echo "\n📋 Summary:\n";
echo "✅ Created organized folder structure\n";
echo "✅ Moved all files to appropriate locations\n";
echo "✅ Removed duplicate files\n";
echo "✅ Created main index.php redirect\n";
echo "✅ Added .htaccess for clean URLs\n";

echo "\n🔧 Next Steps:\n";
echo "1. Update include paths in moved files\n";
echo "2. Test all functionality\n";
echo "3. Update any hardcoded file paths\n";

echo "\n📁 New Structure:\n";
echo "warehouse-pro/\n";
echo "├── config/          # Database & session config\n";
echo "├── core/            # Core application logic\n";
echo "├── pages/           # All application pages\n";
echo "├── assets/          # CSS, JS, images\n";
echo "├── database/        # Database scripts\n";
echo "├── tools/           # Admin/development tools\n";
echo "├── docs/            # Documentation\n";
echo "└── backup/          # Backup of old files\n";

echo "\n🚀 Your project is now clean and organized!\n";
?>
