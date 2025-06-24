<?php
/**
 * Database Structure Checker
 * Quick diagnostic tool to check database structure and identify issues
 */

include('conn.php');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Structure Checker</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; background: #f5f5f5; }
        .success { color: #4CAF50; background: #e8f5e9; padding: 8px; border-radius: 4px; margin: 5px 0; }
        .error { color: #f44336; background: #ffebee; padding: 8px; border-radius: 4px; margin: 5px 0; }
        .warning { color: #ff9800; background: #fff3e0; padding: 8px; border-radius: 4px; margin: 5px 0; }
        .info { color: #2196F3; background: #e3f2fd; padding: 8px; border-radius: 4px; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; background: white; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 12px; }
        th { background: #4CAF50; color: white; }
        .section { margin: 20px 0; padding: 15px; background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .btn { background: #4CAF50; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; font-size: 12px; }
        .btn-danger { background: #f44336; }
        .btn-warning { background: #ff9800; }
    </style>
</head>
<body>";

echo "<h1>🔍 Database Structure Checker</h1>";

try {
    // Check database connection
    echo "<div class='section'>";
    echo "<h2>Database Connection</h2>";
    if ($conn->connect_error) {
        echo "<div class='error'>❌ Connection failed: " . $conn->connect_error . "</div>";
        exit();
    } else {
        echo "<div class='success'>✅ Connected to database successfully</div>";
        echo "<div class='info'>Server: " . $conn->server_info . "</div>";
        echo "<div class='info'>Database: demo</div>";
    }
    echo "</div>";
    
    // Check if tables exist
    echo "<div class='section'>";
    echo "<h2>Table Existence Check</h2>";
    $required_tables = ['user', 'invoice', 'invoice_item'];
    $existing_tables = [];
    
    $show_tables = mysqli_query($conn, "SHOW TABLES");
    while ($row = mysqli_fetch_array($show_tables)) {
        $existing_tables[] = $row[0];
    }
    
    foreach ($required_tables as $table) {
        if (in_array($table, $existing_tables)) {
            echo "<div class='success'>✅ Table '$table' exists</div>";
        } else {
            echo "<div class='error'>❌ Table '$table' is missing</div>";
        }
    }
    echo "</div>";
    
    // Check table structures
    foreach ($required_tables as $table) {
        if (in_array($table, $existing_tables)) {
            echo "<div class='section'>";
            echo "<h2>$table Table Structure</h2>";
            
            $describe_result = mysqli_query($conn, "DESCRIBE $table");
            if ($describe_result) {
                echo "<table>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                while ($row = mysqli_fetch_assoc($describe_result)) {
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
                
                // Check for specific required columns
                if ($table == 'invoice') {
                    $columns_result = mysqli_query($conn, "SHOW COLUMNS FROM invoice");
                    $columns = [];
                    while ($col = mysqli_fetch_assoc($columns_result)) {
                        $columns[] = $col['Field'];
                    }
                    
                    $required_invoice_columns = ['id', 'customer_name', 'date'];
                    foreach ($required_invoice_columns as $req_col) {
                        if (in_array($req_col, $columns)) {
                            echo "<div class='success'>✅ Required column '$req_col' exists</div>";
                        } else {
                            echo "<div class='error'>❌ Required column '$req_col' is missing</div>";
                        }
                    }
                }
                
                // Show record count
                $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
                if ($count_result) {
                    $count = mysqli_fetch_assoc($count_result)['count'];
                    echo "<div class='info'>📊 Records in table: $count</div>";
                }
                
            } else {
                echo "<div class='error'>❌ Could not describe table: " . mysqli_error($conn) . "</div>";
            }
            echo "</div>";
        }
    }
    
    // Test queries
    echo "<div class='section'>";
    echo "<h2>Query Tests</h2>";
    
    // Test invoice list query
    echo "<h3>Testing Invoice List Query</h3>";
    $test_query = "SELECT invoice.id, invoice.customer_name, 
                   COALESCE(invoice.date, invoice.created_at, NOW()) as date,
                   COALESCE(SUM(invoice_item.total_price), 0) AS total_amount
                   FROM invoice
                   LEFT JOIN invoice_item ON invoice_item.invoice_id = invoice.id
                   GROUP BY invoice.id
                   LIMIT 5";
    
    $test_result = mysqli_query($conn, $test_query);
    if ($test_result) {
        echo "<div class='success'>✅ Invoice list query works</div>";
        if (mysqli_num_rows($test_result) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Customer</th><th>Date</th><th>Total</th></tr>";
            while ($row = mysqli_fetch_assoc($test_result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>₹" . number_format($row['total_amount'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='warning'>⚠️ No invoice records found</div>";
        }
    } else {
        echo "<div class='error'>❌ Invoice list query failed: " . mysqli_error($conn) . "</div>";
    }
    
    // Test invoice item query
    echo "<h3>Testing Invoice Item Query</h3>";
    $item_test_query = "SELECT invoice.customer_name, 
                        COALESCE(invoice.date, invoice.created_at, NOW()) as date,
                        invoice_item.item_name, 
                        invoice_item.qty, 
                        invoice_item.mrp, 
                        invoice_item.total_price
                        FROM invoice_item
                        LEFT JOIN invoice ON invoice_item.invoice_id = invoice.id
                        LIMIT 5";
    
    $item_test_result = mysqli_query($conn, $item_test_query);
    if ($item_test_result) {
        echo "<div class='success'>✅ Invoice item query works</div>";
        if (mysqli_num_rows($item_test_result) > 0) {
            echo "<table>";
            echo "<tr><th>Customer</th><th>Date</th><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>";
            while ($row = mysqli_fetch_assoc($item_test_result)) {
                echo "<tr>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['item_name'] . "</td>";
                echo "<td>" . $row['qty'] . "</td>";
                echo "<td>₹" . number_format($row['mrp'], 2) . "</td>";
                echo "<td>₹" . number_format($row['total_price'], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='warning'>⚠️ No invoice item records found</div>";
        }
    } else {
        echo "<div class='error'>❌ Invoice item query failed: " . mysqli_error($conn) . "</div>";
    }
    echo "</div>";
    
    // Recommendations
    echo "<div class='section'>";
    echo "<h2>Recommendations</h2>";
    
    $issues_found = false;
    
    if (!in_array('invoice', $existing_tables)) {
        echo "<div class='error'>❌ Invoice table is missing</div>";
        $issues_found = true;
    }
    
    if (!in_array('invoice_item', $existing_tables)) {
        echo "<div class='error'>❌ Invoice item table is missing</div>";
        $issues_found = true;
    }
    
    if (in_array('invoice', $existing_tables)) {
        $columns_result = mysqli_query($conn, "SHOW COLUMNS FROM invoice");
        $columns = [];
        while ($col = mysqli_fetch_assoc($columns_result)) {
            $columns[] = $col['Field'];
        }
        
        if (!in_array('date', $columns) && !in_array('created_at', $columns)) {
            echo "<div class='error'>❌ Invoice table missing date column</div>";
            $issues_found = true;
        }
    }
    
    if ($issues_found) {
        echo "<div class='warning'>⚠️ Database structure issues detected. Please run the schema fix.</div>";
        echo "<a href='database_schema_fix.php' class='btn btn-danger'>Fix Database Schema</a>";
    } else {
        echo "<div class='success'>✅ Database structure looks good!</div>";
        echo "<a href='invoice.php' class='btn'>Create Invoice</a>";
        echo "<a href='invoicelist.php' class='btn'>View Invoices</a>";
    }
    
    echo "<a href='welcomepage.php' class='btn'>Back to Dashboard</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>❌ Error: " . $e->getMessage() . "</div>";
}

mysqli_close($conn);

echo "</body></html>";
?>
