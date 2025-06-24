<?php
include('conn.php');
include('session.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: invoice.php');
    exit();
}

// Validate and sanitize input data
$customer_name = mysqli_real_escape_string($conn, $_POST['customername'] ?? '');
$item_name = $_POST['itemname'] ?? [];
$qty = $_POST['qty'] ?? [];
$mrp = $_POST['mrp'] ?? [];
$price = $_POST['price'] ?? [];

// Validate required fields
if (empty($customer_name)) {
    $error_messages[] = "Customer name is required";
}

if (empty($item_name) || !is_array($item_name)) {
    $error_messages[] = "At least one item is required";
}

$last_id = null;
$success_count = 0;
$error_messages = $error_messages ?? [];

// Start transaction for data integrity
mysqli_begin_transaction($conn);

try {
    // Check if there are validation errors before proceeding
    if (!empty($error_messages)) {
        throw new Exception("Validation failed: " . implode(", ", $error_messages));
    }

    // Insert invoice record
    $sql = "INSERT INTO invoice (customer_name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare invoice statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $customer_name);

    if (mysqli_stmt_execute($stmt)) {
        $last_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Insert invoice items with better error handling
        $item_sql = "INSERT INTO invoice_item (invoice_id, item_name, qty, mrp, total_price) VALUES (?, ?, ?, ?, ?)";
        $item_stmt = mysqli_prepare($conn, $item_sql);

        if (!$item_stmt) {
            throw new Exception("Failed to prepare item statement: " . mysqli_error($conn));
        }

        foreach($item_name as $key => $value) {
            // Validate that all required fields exist for this item
            if (isset($qty[$key]) && isset($mrp[$key]) && isset($price[$key])) {
                // Sanitize and validate data
                $current_item = trim($item_name[$key]);
                $current_qty = (int)$qty[$key];
                $current_mrp = (float)$mrp[$key];
                $current_price = (float)$price[$key];

                // Additional validation
                if (empty($current_item)) {
                    $error_messages[] = "Item name cannot be empty for item " . ($key + 1);
                    continue;
                }

                if ($current_qty <= 0) {
                    $error_messages[] = "Quantity must be greater than 0 for item '$current_item'";
                    continue;
                }

                if ($current_mrp < 0) {
                    $error_messages[] = "Price cannot be negative for item '$current_item'";
                    continue;
                }

                // Bind parameters and execute (note the correct order: invoice_id first)
                mysqli_stmt_bind_param($item_stmt, "isidd", $last_id, $current_item, $current_qty, $current_mrp, $current_price);

                if (mysqli_stmt_execute($item_stmt)) {
                    $success_count++;
                } else {
                    $error_messages[] = "Error inserting item '$current_item': " . mysqli_stmt_error($item_stmt);
                }
            } else {
                $error_messages[] = "Missing data for item at index " . ($key + 1);
            }
        }

        mysqli_stmt_close($item_stmt);

        // Check if all items were inserted successfully
        if (empty($error_messages)) {
            // Commit transaction
            mysqli_commit($conn);
            include('header.php');
            echo "<div class='success-container'>
                    <div class='success-message'>
                        <i class='material-icons large'>check_circle</i>
                        <h4>Invoice Created Successfully!</h4>
                        <div class='invoice-details'>
                            <p><strong>Invoice ID:</strong> #$last_id</p>
                            <p><strong>Customer:</strong> $customer_name</p>
                            <p><strong>Items Added:</strong> $success_count</p>
                            <p><strong>Date:</strong> " . date('M d, Y H:i') . "</p>
                        </div>
                        <div class='action-buttons'>
                            <a href='itemlist.php?id=$last_id' class='btn btn-primary'>
                                <i class='material-icons left'>visibility</i>View Invoice
                            </a>
                            <a href='invoice.php' class='btn btn-secondary'>
                                <i class='material-icons left'>add</i>Create New Invoice
                            </a>
                            <a href='invoicelist.php' class='btn btn-tertiary'>
                                <i class='material-icons left'>list</i>All Invoices
                            </a>
                        </div>
                    </div>
                  </div>";
        } else {
            // Rollback transaction
            mysqli_rollback($conn);
            include('header.php');
            echo "<div class='error-container'>
                    <div class='error-message'>
                        <i class='material-icons large'>error</i>
                        <h4>Error Creating Invoice</h4>
                        <div class='error-details'>";
            foreach ($error_messages as $error) {
                echo "<p><i class='material-icons tiny'>warning</i> $error</p>";
            }
            echo "      </div>
                        <div class='action-buttons'>
                            <a href='invoice.php' class='btn btn-secondary'>
                                <i class='material-icons left'>refresh</i>Try Again
                            </a>
                            <a href='quick_fix.php' class='btn btn-warning'>
                                <i class='material-icons left'>build</i>Fix Database
                            </a>
                        </div>
                    </div>
                  </div>";
        }

    } else {
        throw new Exception("Error creating invoice: " . mysqli_stmt_error($stmt));
    }

} catch (Exception $e) {
    // Rollback transaction on any error
    mysqli_rollback($conn);
    include('header.php');
    echo "<div class='error-container'>
            <div class='error-message'>
                <i class='material-icons large'>error_outline</i>
                <h4>Database Error</h4>
                <div class='error-details'>
                    <p><i class='material-icons tiny'>bug_report</i> " . htmlspecialchars($e->getMessage()) . "</p>
                </div>
                <div class='action-buttons'>
                    <a href='invoice.php' class='btn btn-secondary'>
                        <i class='material-icons left'>refresh</i>Try Again
                    </a>
                    <a href='quick_fix.php' class='btn btn-warning'>
                        <i class='material-icons left'>build</i>Fix Database Issue
                    </a>
                    <a href='welcomepage.php' class='btn btn-tertiary'>
                        <i class='material-icons left'>home</i>Go to Dashboard
                    </a>
                </div>
            </div>
          </div>";
}

mysqli_close($conn);
?>

<style>
body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

.success-container, .error-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
}

.success-message, .error-message {
    max-width: 600px;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    animation: slideInUp 0.6s ease-out;
}

.success-message {
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.9), rgba(69, 160, 73, 0.9));
    color: white;
    box-shadow: 0 20px 40px rgba(76, 175, 80, 0.3);
}

.error-message {
    background: linear-gradient(135deg, rgba(244, 67, 54, 0.9), rgba(211, 47, 47, 0.9));
    color: white;
    box-shadow: 0 20px 40px rgba(244, 67, 54, 0.3);
}

.success-message i.large, .error-message i.large {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.9;
}

.success-message h4, .error-message h4 {
    margin: 20px 0;
    font-size: 2rem;
    font-weight: 500;
}

.invoice-details, .error-details {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
    text-align: left;
}

.invoice-details p, .error-details p {
    margin: 10px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.action-buttons {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 14px;
}

.btn-primary {
    background: linear-gradient(135deg, #2196F3, #1976D2);
    color: white;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-tertiary {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-warning {
    background: linear-gradient(135deg, #FF9800, #F57C00);
    color: white;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.btn i.material-icons {
    font-size: 18px;
}

.btn i.tiny {
    font-size: 16px;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsive */
@media (max-width: 768px) {
    .success-message, .error-message {
        padding: 30px 20px;
        margin: 20px;
    }

    .action-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}
</style>

<?php include('footer.php'); ?>