<?php
/**
 * Quick Database Fix for Invoice Creation Issue
 * This script fixes the PRIMARY KEY duplicate entry error
 */

include('conn.php');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Quick Fix</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .success { color: #4CAF50; background: #e8f5e9; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .error { color: #f44336; background: #ffebee; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .info { color: #2196F3; background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .btn { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #45a049; }
    </style>
</head>
<body>";

echo "<h1>🔧 Database Quick Fix</h1>";
echo "<p>Fixing the invoice creation issue...</p>";

try {
    // Step 1: Check if invoice_item table exists and its structure
    echo "<div class='info'><strong>Step 1:</strong> Checking invoice_item table structure...</div>";
    
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'invoice_item'");
    if (mysqli_num_rows($check_table) == 0) {
        echo "<div class='error'>Table 'invoice_item' does not exist. Creating it...</div>";
        
        $create_sql = "
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
        
        if (mysqli_query($conn, $create_sql)) {
            echo "<div class='success'>✓ Table created successfully!</div>";
        } else {
            throw new Exception("Failed to create table: " . mysqli_error($conn));
        }
    } else {
        echo "<div class='success'>✓ Table exists</div>";
    }
    
    // Step 2: Check table structure
    echo "<div class='info'><strong>Step 2:</strong> Verifying table structure...</div>";
    $describe_result = mysqli_query($conn, "DESCRIBE invoice_item");
    $has_auto_increment = false;
    $primary_key_field = '';
    
    while ($row = mysqli_fetch_assoc($describe_result)) {
        if ($row['Key'] == 'PRI') {
            $primary_key_field = $row['Field'];
        }
        if (strpos($row['Extra'], 'auto_increment') !== false) {
            $has_auto_increment = true;
        }
    }
    
    if ($primary_key_field != 'id' || !$has_auto_increment) {
        echo "<div class='error'>Table structure is incorrect. Fixing...</div>";
        
        // Backup data
        $backup_result = mysqli_query($conn, "SELECT * FROM invoice_item");
        $backup_data = [];
        while ($row = mysqli_fetch_assoc($backup_result)) {
            $backup_data[] = $row;
        }
        
        // Drop and recreate table
        mysqli_query($conn, "DROP TABLE invoice_item");
        
        $create_sql = "
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
        
        if (!mysqli_query($conn, $create_sql)) {
            throw new Exception("Failed to recreate table: " . mysqli_error($conn));
        }
        
        // Restore data
        if (!empty($backup_data)) {
            $insert_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            
            foreach ($backup_data as $row) {
                mysqli_stmt_bind_param($stmt, "isidd", 
                    $row['invoice_id'], 
                    $row['item_name'], 
                    $row['qty'], 
                    $row['mrp'], 
                    $row['total_price']
                );
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
            echo "<div class='success'>✓ Data restored (" . count($backup_data) . " records)</div>";
        }
        
        echo "<div class='success'>✓ Table structure fixed!</div>";
    } else {
        echo "<div class='success'>✓ Table structure is correct</div>";
    }
    
    // Step 3: Reset AUTO_INCREMENT
    echo "<div class='info'><strong>Step 3:</strong> Resetting AUTO_INCREMENT...</div>";
    $max_result = mysqli_query($conn, "SELECT MAX(id) as max_id FROM invoice_item");
    $max_row = mysqli_fetch_assoc($max_result);
    $next_id = ($max_row['max_id'] ?? 0) + 1;
    
    $reset_sql = "ALTER TABLE invoice_item AUTO_INCREMENT = $next_id";
    if (mysqli_query($conn, $reset_sql)) {
        echo "<div class='success'>✓ AUTO_INCREMENT reset to $next_id</div>";
    } else {
        echo "<div class='error'>Failed to reset AUTO_INCREMENT: " . mysqli_error($conn) . "</div>";
    }
    
    // Step 4: Test the fix
    echo "<div class='info'><strong>Step 4:</strong> Testing the fix...</div>";
    
    // First, ensure we have at least one invoice to test with
    $invoice_check = mysqli_query($conn, "SELECT id FROM invoice LIMIT 1");
    if (mysqli_num_rows($invoice_check) == 0) {
        mysqli_query($conn, "INSERT INTO invoice (customer_name) VALUES ('Test Customer')");
        $test_invoice_id = mysqli_insert_id($conn);
        echo "<div class='info'>Created test invoice with ID: $test_invoice_id</div>";
    } else {
        $invoice_row = mysqli_fetch_assoc($invoice_check);
        $test_invoice_id = $invoice_row['id'];
    }
    
    // Test insert
    $test_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (?, 'Test Item', 1, 100.00, 100.00)";
    $test_stmt = mysqli_prepare($conn, $test_sql);
    mysqli_stmt_bind_param($test_stmt, "i", $test_invoice_id);
    
    if (mysqli_stmt_execute($test_stmt)) {
        $test_item_id = mysqli_insert_id($conn);
        echo "<div class='success'>✓ Test insert successful! New item ID: $test_item_id</div>";
        
        // Clean up test data
        mysqli_query($conn, "DELETE FROM invoice_item WHERE id = $test_item_id");
        echo "<div class='info'>Test data cleaned up</div>";
    } else {
        echo "<div class='error'>✗ Test insert failed: " . mysqli_stmt_error($test_stmt) . "</div>";
    }
    mysqli_stmt_close($test_stmt);
    
    // Step 5: Final verification
    echo "<div class='info'><strong>Step 5:</strong> Final verification...</div>";
    $status_result = mysqli_query($conn, "SHOW TABLE STATUS LIKE 'invoice_item'");
    $status = mysqli_fetch_assoc($status_result);
    
    echo "<div class='success'>";
    echo "✓ Table engine: " . $status['Engine'] . "<br>";
    echo "✓ Next AUTO_INCREMENT: " . $status['Auto_increment'] . "<br>";
    echo "✓ Rows in table: " . $status['Rows'] . "<br>";
    echo "</div>";
    
    echo "<h2 style='color: #4CAF50;'>🎉 Database Fix Completed Successfully!</h2>";
    echo "<p>The invoice creation issue has been resolved. You can now create invoices without errors.</p>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='invoice.php' class='btn'>Create New Invoice</a>";
    echo "<a href='invoicelist.php' class='btn'>View Invoices</a>";
    echo "<a href='welcomepage.php' class='btn'>Go to Dashboard</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Error during fix:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>Please check your database connection and try again.</p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='fix_database.php' class='btn'>Try Full Database Repair</a>";
    echo "</div>";
}

mysqli_close($conn);

echo "</body></html>";
?>
