<?php
/**
 * Database Fix Script for Invoice Item Table
 * This script will fix the PRIMARY KEY issue in the invoice_item table
 */

include('conn.php');

echo "<h2>Database Repair Script</h2>";
echo "<p>Fixing invoice_item table structure...</p>";

try {
    // Start transaction
    mysqli_begin_transaction($conn);
    
    // Step 1: Check current table structure
    echo "<h3>Step 1: Checking current table structure</h3>";
    $result = mysqli_query($conn, "DESCRIBE invoice_item");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
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
    
    // Step 2: Backup existing data
    echo "<h3>Step 2: Backing up existing data</h3>";
    $backup_result = mysqli_query($conn, "SELECT * FROM invoice_item");
    $backup_data = [];
    if ($backup_result) {
        while ($row = mysqli_fetch_assoc($backup_result)) {
            $backup_data[] = $row;
        }
        echo "<p>Backed up " . count($backup_data) . " records.</p>";
    }
    
    // Step 3: Drop and recreate table with correct structure
    echo "<h3>Step 3: Recreating table with correct structure</h3>";
    
    // Drop the table
    $drop_result = mysqli_query($conn, "DROP TABLE IF EXISTS invoice_item");
    if (!$drop_result) {
        throw new Exception("Failed to drop table: " . mysqli_error($conn));
    }
    echo "<p>✓ Old table dropped successfully</p>";
    
    // Create new table with correct structure
    $create_sql = "
    CREATE TABLE invoice_item (
        id INT AUTO_INCREMENT PRIMARY KEY,
        invoice_id INT NOT NULL,
        item_name VARCHAR(200) NOT NULL,
        qty INT NOT NULL DEFAULT 1,
        mrp DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        total_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (invoice_id) REFERENCES invoice(id) ON DELETE CASCADE,
        INDEX idx_invoice_id (invoice_id)
    )";
    
    $create_result = mysqli_query($conn, $create_sql);
    if (!$create_result) {
        throw new Exception("Failed to create table: " . mysqli_error($conn));
    }
    echo "<p>✓ New table created successfully</p>";
    
    // Step 4: Restore data
    echo "<h3>Step 4: Restoring backed up data</h3>";
    if (!empty($backup_data)) {
        $insert_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_sql);
        
        $restored_count = 0;
        foreach ($backup_data as $row) {
            // Skip the old 'id' field if it exists, let AUTO_INCREMENT handle it
            $invoice_id = $row['invoice_id'];
            $item_name = $row['item_name'];
            $qty = $row['qty'];
            $mrp = $row['mrp'];
            $total_price = $row['total_price'];
            
            mysqli_stmt_bind_param($stmt, "isidd", $invoice_id, $item_name, $qty, $mrp, $total_price);
            
            if (mysqli_stmt_execute($stmt)) {
                $restored_count++;
            } else {
                echo "<p style='color: red;'>Failed to restore record: " . mysqli_stmt_error($stmt) . "</p>";
            }
        }
        
        mysqli_stmt_close($stmt);
        echo "<p>✓ Restored $restored_count out of " . count($backup_data) . " records</p>";
    } else {
        echo "<p>No data to restore</p>";
    }
    
    // Step 5: Verify new structure
    echo "<h3>Step 5: Verifying new table structure</h3>";
    $verify_result = mysqli_query($conn, "DESCRIBE invoice_item");
    if ($verify_result) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = mysqli_fetch_assoc($verify_result)) {
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
    
    // Step 6: Reset AUTO_INCREMENT to ensure no conflicts
    echo "<h3>Step 6: Resetting AUTO_INCREMENT</h3>";
    $max_id_result = mysqli_query($conn, "SELECT MAX(id) as max_id FROM invoice_item");
    $max_id_row = mysqli_fetch_assoc($max_id_result);
    $next_id = ($max_id_row['max_id'] ?? 0) + 1;

    $reset_sql = "ALTER TABLE invoice_item AUTO_INCREMENT = $next_id";
    $reset_result = mysqli_query($conn, $reset_sql);
    if ($reset_result) {
        echo "<p style='color: green;'>✓ AUTO_INCREMENT reset to $next_id</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to reset AUTO_INCREMENT: " . mysqli_error($conn) . "</p>";
    }

    // Step 7: Test insert
    echo "<h3>Step 7: Testing new structure</h3>";
    $test_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (1, 'Test Item', 1, 100.00, 100.00)";
    $test_result = mysqli_query($conn, $test_sql);
    if ($test_result) {
        echo "<p style='color: green;'>✓ Test insert successful</p>";
        $test_id = mysqli_insert_id($conn);
        echo "<p>New record ID: $test_id</p>";
        // Clean up test data
        mysqli_query($conn, "DELETE FROM invoice_item WHERE item_name = 'Test Item'");
    } else {
        echo "<p style='color: red;'>✗ Test insert failed: " . mysqli_error($conn) . "</p>";
    }

    // Step 8: Check for any remaining issues
    echo "<h3>Step 8: Final verification</h3>";
    $check_sql = "SHOW TABLE STATUS LIKE 'invoice_item'";
    $check_result = mysqli_query($conn, $check_sql);
    if ($check_result) {
        $status = mysqli_fetch_assoc($check_result);
        echo "<p>Table engine: " . $status['Engine'] . "</p>";
        echo "<p>Next AUTO_INCREMENT: " . $status['Auto_increment'] . "</p>";
        echo "<p>Collation: " . $status['Collation'] . "</p>";
    }
    
    // Commit transaction
    mysqli_commit($conn);
    echo "<h3 style='color: green;'>✓ Database repair completed successfully!</h3>";
    echo "<p><a href='invoice.php' style='background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Create New Invoice</a></p>";
    
} catch (Exception $e) {
    // Rollback on error
    mysqli_rollback($conn);
    echo "<h3 style='color: red;'>✗ Error during repair: " . $e->getMessage() . "</h3>";
    echo "<p>Please check your database connection and try again.</p>";
}

mysqli_close($conn);
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f5f5f5;
}

h2, h3 {
    color: #333;
}

table {
    background: white;
    width: 100%;
}

th {
    background: #4CAF50;
    color: white;
    padding: 8px;
}

td {
    padding: 8px;
    border: 1px solid #ddd;
}

p {
    margin: 10px 0;
}
</style>
