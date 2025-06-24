<?php
/**
 * Complete Database Schema Fix
 * This script fixes all database structure issues including missing columns
 */

include('conn.php');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Schema Fix</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .success { color: #4CAF50; background: #e8f5e9; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #f44336; background: #ffebee; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #2196F3; background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .warning { color: #ff9800; background: #fff3e0; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #45a049; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #4CAF50; color: white; }
        .step { margin: 20px 0; padding: 15px; background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>";

echo "<h1>🔧 Complete Database Schema Fix</h1>";
echo "<p>This script will fix all database structure issues including missing columns and incorrect table structures.</p>";

try {
    // Start transaction
    mysqli_begin_transaction($conn);
    
    echo "<div class='step'>";
    echo "<h2>Step 1: Checking Current Database Structure</h2>";
    
    // Check if tables exist
    $tables_to_check = ['user', 'invoice', 'invoice_item'];
    $existing_tables = [];
    
    foreach ($tables_to_check as $table) {
        $check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if (mysqli_num_rows($check_table) > 0) {
            $existing_tables[] = $table;
            echo "<div class='success'>✓ Table '$table' exists</div>";
        } else {
            echo "<div class='error'>✗ Table '$table' does not exist</div>";
        }
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>Step 2: Creating/Updating User Table</h2>";
    
    if (in_array('user', $existing_tables)) {
        // Check user table structure
        $user_columns = [];
        $result = mysqli_query($conn, "DESCRIBE user");
        while ($row = mysqli_fetch_assoc($result)) {
            $user_columns[] = $row['Field'];
        }
        
        // Add missing columns
        $required_columns = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'first_name' => 'VARCHAR(100) NOT NULL',
            'last_name' => 'VARCHAR(100) NOT NULL',
            'email' => 'VARCHAR(150) NOT NULL',
            'user_name' => 'VARCHAR(50) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        
        foreach ($required_columns as $column => $definition) {
            if (!in_array($column, $user_columns)) {
                $alter_sql = "ALTER TABLE user ADD COLUMN $column $definition";
                if (mysqli_query($conn, $alter_sql)) {
                    echo "<div class='success'>✓ Added column '$column' to user table</div>";
                } else {
                    echo "<div class='error'>✗ Failed to add column '$column': " . mysqli_error($conn) . "</div>";
                }
            }
        }
    } else {
        // Create user table
        $create_user_sql = "
        CREATE TABLE user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL,
            user_name VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY unique_email (email),
            UNIQUE KEY unique_username (user_name)
        )";
        
        if (mysqli_query($conn, $create_user_sql)) {
            echo "<div class='success'>✓ User table created successfully</div>";
        } else {
            echo "<div class='error'>✗ Failed to create user table: " . mysqli_error($conn) . "</div>";
        }
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>Step 3: Creating/Updating Invoice Table</h2>";
    
    if (in_array('invoice', $existing_tables)) {
        // Check invoice table structure
        $invoice_columns = [];
        $result = mysqli_query($conn, "DESCRIBE invoice");
        while ($row = mysqli_fetch_assoc($result)) {
            $invoice_columns[] = $row['Field'];
        }
        
        // Add missing columns
        $required_columns = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'customer_name' => 'VARCHAR(200) NOT NULL',
            'email' => 'VARCHAR(150) NULL',
            'date' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'status' => "ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending'",
            'total_amount' => 'DECIMAL(10,2) DEFAULT 0.00',
            'notes' => 'TEXT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ];
        
        foreach ($required_columns as $column => $definition) {
            if (!in_array($column, $invoice_columns)) {
                if ($column == 'id') continue; // Skip if primary key already exists
                
                $alter_sql = "ALTER TABLE invoice ADD COLUMN $column $definition";
                if (mysqli_query($conn, $alter_sql)) {
                    echo "<div class='success'>✓ Added column '$column' to invoice table</div>";
                } else {
                    echo "<div class='error'>✗ Failed to add column '$column': " . mysqli_error($conn) . "</div>";
                }
            }
        }
    } else {
        // Create invoice table
        $create_invoice_sql = "
        CREATE TABLE invoice (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(200) NOT NULL,
            email VARCHAR(150) NULL,
            date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
            total_amount DECIMAL(10,2) DEFAULT 0.00,
            notes TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_customer_name (customer_name),
            INDEX idx_date (date),
            INDEX idx_status (status)
        )";
        
        if (mysqli_query($conn, $create_invoice_sql)) {
            echo "<div class='success'>✓ Invoice table created successfully</div>";
        } else {
            echo "<div class='error'>✗ Failed to create invoice table: " . mysqli_error($conn) . "</div>";
        }
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>Step 4: Creating/Updating Invoice Item Table</h2>";
    
    // Always recreate invoice_item table to ensure correct structure
    if (in_array('invoice_item', $existing_tables)) {
        // Backup existing data
        $backup_result = mysqli_query($conn, "SELECT * FROM invoice_item");
        $backup_data = [];
        if ($backup_result) {
            while ($row = mysqli_fetch_assoc($backup_result)) {
                $backup_data[] = $row;
            }
            echo "<div class='info'>Backed up " . count($backup_data) . " invoice items</div>";
        }
        
        // Drop existing table
        mysqli_query($conn, "DROP TABLE invoice_item");
        echo "<div class='warning'>Dropped existing invoice_item table</div>";
    }
    
    // Create invoice_item table with correct structure
    $create_invoice_item_sql = "
    CREATE TABLE invoice_item (
        id INT AUTO_INCREMENT PRIMARY KEY,
        invoice_id INT NOT NULL,
        item_name VARCHAR(200) NOT NULL,
        qty INT NOT NULL DEFAULT 1,
        mrp DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_invoice_id (invoice_id)
    )";
    
    if (mysqli_query($conn, $create_invoice_item_sql)) {
        echo "<div class='success'>✓ Invoice item table created successfully</div>";
        
        // Restore backed up data
        if (!empty($backup_data)) {
            $insert_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            
            $restored_count = 0;
            foreach ($backup_data as $row) {
                mysqli_stmt_bind_param($stmt, "isidd", 
                    $row['invoice_id'], 
                    $row['item_name'], 
                    $row['qty'], 
                    $row['mrp'], 
                    $row['total_price']
                );
                if (mysqli_stmt_execute($stmt)) {
                    $restored_count++;
                }
            }
            mysqli_stmt_close($stmt);
            echo "<div class='success'>✓ Restored $restored_count invoice items</div>";
        }
    } else {
        echo "<div class='error'>✗ Failed to create invoice_item table: " . mysqli_error($conn) . "</div>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>Step 5: Adding Sample Data (if needed)</h2>";
    
    // Check if we have any users
    $user_count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
    $user_count = mysqli_fetch_assoc($user_count_result)['count'];
    
    if ($user_count == 0) {
        $insert_user_sql = "INSERT INTO user (first_name, last_name, email, user_name, password) VALUES 
                           ('Admin', 'User', 'admin@warehouse.com', 'admin', MD5('admin123')),
                           ('John', 'Doe', 'john@example.com', 'john', MD5('password123'))";
        
        if (mysqli_query($conn, $insert_user_sql)) {
            echo "<div class='success'>✓ Added sample users</div>";
        } else {
            echo "<div class='warning'>Could not add sample users: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='info'>Users already exist ($user_count users)</div>";
    }
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h2>Step 6: Final Verification</h2>";
    
    // Show final table structures
    $tables = ['user', 'invoice', 'invoice_item'];
    foreach ($tables as $table) {
        echo "<h3>$table table structure:</h3>";
        $result = mysqli_query($conn, "DESCRIBE $table");
        if ($result) {
            echo "<table>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Field'] . "</td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    echo "</div>";
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo "<div class='step'>";
    echo "<h2 style='color: #4CAF50;'>🎉 Database Schema Fix Completed Successfully!</h2>";
    echo "<p>All database structure issues have been resolved. The application should now work correctly.</p>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='invoice.php' class='btn'>Create New Invoice</a>";
    echo "<a href='invoicelist.php' class='btn'>View Invoices</a>";
    echo "<a href='welcomepage.php' class='btn'>Go to Dashboard</a>";
    echo "</div>";
    echo "</div>";
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<div class='error'>";
    echo "<h3>❌ Error during schema fix:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}

mysqli_close($conn);

echo "</body></html>";
?>
